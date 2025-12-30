<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $query = Order::with(['user', 'shippingAddress', 'billingAddress']);

        // Search by order ID or user name/email
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('id', $search)
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  });
            });
        }

        // Filter by status
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        // Filter by payment status
        if ($payment = request('payment_status')) {
            $query->where('payment_status', $payment);
        }

        $orders = $query->latest()->paginate(20)->appends(request()->query());

        // Payment method summary
        $paymentSummary = [
            'Bkash' => Order::where('payment_method', 'Bkash')->sum('total'),
            'Cash' => Order::where('payment_method', 'Cash')->sum('total'),
            'Nagad' => Order::where('payment_method', 'Nagad')->sum('total'),
            'Bank' => Order::where('payment_method', 'Bank')->sum('total'),
            'Master Card' => Order::where('payment_method', 'Master Card')->sum('total'),
        ];

        return view('admin.orders.index', compact('orders', 'paymentSummary'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        // You may want to pass users, addresses, products, etc. for selection
        return view('admin.orders.create');
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'shipping_address_id' => 'nullable|exists:addresses,id',
            'billing_address_id' => 'nullable|exists:addresses,id',
            'status' => 'required|string',
            'total' => 'required|numeric',
            'payment_status' => 'required|string',
            'coupon_code' => 'nullable|string',
        ]);
        $order = Order::create($validated);

        // Coupon validation logic
        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->where('active', true)->first();
            if ($coupon) {
                $applies = false;
                $orderProducts = $order->items()->with('product')->get();
                foreach ($orderProducts as $item) {
                    $product = $item->product;
                    if (
                        (is_array($coupon->product_ids) && in_array($product->id, $coupon->product_ids)) ||
                        (is_array($coupon->category_ids) && in_array($product->category_id, $coupon->category_ids)) ||
                        (is_array($coupon->brand_ids) && in_array($product->brand_id, $coupon->brand_ids))
                    ) {
                        $applies = true;
                        break;
                    }
                }
                if ($applies) {
                    // Apply coupon discount logic here
                    // Example: $order->discount = $coupon->value; $order->save();
                } else {
                    // Coupon does not apply to any product/category/brand in order
                    // Optionally: $order->discount = 0; $order->save();
                }
            }
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified order details.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user', 'shippingAddress', 'billingAddress', 'payments', 'statusHistories.changedBy']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        // You may want to pass users, addresses, products, etc. for selection
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'shipping_address_id' => 'nullable|exists:addresses,id',
            'billing_address_id' => 'nullable|exists:addresses,id',
            'status' => 'required|string',
            'total' => 'required|numeric',
            'payment_status' => 'required|string',
        ]);
        $order->update($validated);
        // Optionally handle order items, payments, etc. here
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
