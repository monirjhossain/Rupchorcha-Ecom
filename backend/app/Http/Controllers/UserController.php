<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // User list (admin)
    public function index()
    {
        $query = User::query();
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }
        if ($role = request('role')) {
            $query->where('role', $role);
        }
        $users = $query->get();
        return view('admin.users.index', compact('users'));
    }
    // Toggle user active status
    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();
        return back()->with('success', 'User status updated.');
    }

    // ...existing code...
    // Send email or SMS to customer
    public function sendMessage(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'message_type' => 'required|in:email,sms',
            'message' => 'required|string',
        ]);
        if ($request->message_type === 'email') {
            \Mail::send([], [], function($mail) use ($user, $request) {
                $mail->to($user->email)
                    ->subject('Message from Admin')
                    ->setBody($request->message, 'text/html');
            });
            return back()->with('success', 'Email sent successfully!');
        } elseif ($request->message_type === 'sms') {
            // Implement SMS sending logic here (integration required)
            // Example: SmsService::send($user->phone, $request->message);
            return back()->with('success', 'SMS sent (simulation).');
        }
        return back()->with('error', 'Invalid message type.');
    }

    // Show create user form (admin)
    public function create()
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can create users.');
        }
        return view('admin.users.create');
    }

    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Always set as customer for public registration
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Auth::login($user);
        return redirect('/admin');
    }
     // Show customer details
    public function show($id)
    {
        $user = User::with('orders')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Store new user (admin)
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can create users.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:super_admin,admin,shop_manager,content_manager,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show edit user form (admin)
    public function edit($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can edit users.');
        }
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update user (admin)
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can update users.');
        }
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,admin,shop_manager,content_manager,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Delete user (admin)
    public function destroy($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can delete users.');
        }
        $user = User::findOrFail($id);
        if ($user->role === 'super_admin') {
            return redirect()->route('users.index')->with('error', 'Cannot delete super admin.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
        /**
     * Handle bulk SMS sending to selected users.
     */
    public function bulk_sms(Request $request)
    {
        $request->validate([
            'sms_message' => 'required|string',
            'sms_api_key' => 'required|string',
            'user_ids' => 'required|array',
        ]);

        $users = \App\Models\User::whereIn('id', $request->user_ids)->whereNotNull('phone')->get();
        $count = 0;
        foreach ($users as $user) {
            // sendSms($user->phone, $request->sms_message, $request->sms_api_key); // Implement this
            $count++;
        }
        return redirect()->route('users.index')->with('success', "Bulk SMS sent to $count users.");
    }
}
