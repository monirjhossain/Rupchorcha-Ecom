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
        $users = User::all();
        return view('admin.users.index', compact('users'));
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
}
