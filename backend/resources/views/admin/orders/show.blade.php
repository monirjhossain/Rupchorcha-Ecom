@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Order Details</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h5>Order #{{ $order->id }}</h5>
            <p><strong>Status:</strong> {{ $order->status }}</p>
            <p><strong>User:</strong> {{ $order->user ? $order->user->name : 'N/A' }}</p>
            <p><strong>Total:</strong> {{ number_format($order->total, 2) }}</p>
            <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            <hr>
            <h6>Order Items</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
