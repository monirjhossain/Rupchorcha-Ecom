
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Create Order</h1>
    <form action="{{ route('orders.store') }}" method="POST" id="order-create-form">
        @csrf
        <div class="row">
            <!-- Customer Selection -->
            <div class="col-lg-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white"><i class="fas fa-user mr-2"></i> Customer</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Select Customer <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control select2" required>
                                <option value="">Select customer</option>
                                <option value="0">Guest</option>
                                @foreach(App\Models\User::orderBy('name')->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Shipping Address Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white"><i class="fas fa-shipping-fast mr-2"></i> Shipping Address</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>First name</label>
                                <input type="text" name="shipping_first_name" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last name</label>
                                <input type="text" name="shipping_last_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="shipping_company" class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Address line 1</label>
                                <input type="text" name="shipping_address_1" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Address line 2</label>
                                <input type="text" name="shipping_address_2" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" name="shipping_city" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Postcode / ZIP</label>
                                <input type="text" name="shipping_postcode" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Country / Region</label>
                                <select name="shipping_country" class="form-control">
                                    <option value="Bangladesh">Bangladesh</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>State / County</label>
                                <select name="shipping_state" class="form-control">
                                    <option value="">Select an option...</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Chattogram">Chattogram</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email address</label>
                                <input type="email" name="shipping_email" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone</label>
                                <input type="text" name="shipping_phone" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Billing Address Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white"><i class="fas fa-file-invoice mr-2"></i> Billing Address</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>First name</label>
                                <input type="text" name="billing_first_name" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last name</label>
                                <input type="text" name="billing_last_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="billing_company" class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Address line 1</label>
                                <input type="text" name="billing_address_1" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Address line 2</label>
                                <input type="text" name="billing_address_2" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" name="billing_city" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Postcode / ZIP</label>
                                <input type="text" name="billing_postcode" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Country / Region</label>
                                <select name="billing_country" class="form-control">
                                    <option value="Bangladesh">Bangladesh</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>State / County</label>
                                <select name="billing_state" class="form-control">
                                    <option value="">Select an option...</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Chattogram">Chattogram</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email address</label>
                                <input type="email" name="billing_email" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone</label>
                                <input type="text" name="billing_phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Payment method</label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="Bkash">Bkash</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Bank">Bank</option>
                                    <option value="Master Card">Master Card</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Transaction ID</label>
                                <input type="text" name="transaction_id" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Payment Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white"><i class="fas fa-credit-card mr-2"></i> Payment</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="payment_status">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-control" required>
                                <option value="unpaid">Unpaid</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Items Section -->
            <div class="col-lg-8">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-warning text-dark"><i class="fas fa-boxes mr-2"></i> Order Items</div>
                    <div class="card-body">
                        <table class="table table-bordered" id="order-items-table">
                            <thead>
                                <tr>
                                    <th style="width:40%">Product</th>
                                    <th style="width:15%">Price</th>
                                    <th style="width:15%">Qty</th>
                                    <th style="width:15%">Subtotal</th>
                                    <th style="width:15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="products[]" class="form-control select2-product" required>
                                            <option value="">Select product</option>
                                            @foreach(App\Models\Product::orderBy('name')->get() as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} (৳{{ $product->price }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="prices[]" class="form-control price-input" step="0.01" min="0" required></td>
                                    <td><input type="number" name="quantities[]" class="form-control qty-input" min="1" value="1" required></td>
                                    <td><input type="number" name="subtotals[]" class="form-control subtotal-input" readonly></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-secondary btn-sm" id="add-order-item"><i class="fas fa-plus"></i> Add Product</button>
                    </div>
                </div>
                <!-- Order Summary -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light"><i class="fas fa-receipt mr-2"></i> Order Summary</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Order Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Enter coupon code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" step="0.01" name="total" id="total" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Create Order</button>
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- Select2 CSS & JS CDN -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.select2').select2({ width: '100%' });
        // Product row add/remove
        $('#add-order-item').on('click', function() {
            let row = $('#order-items-table tbody tr:first').clone();
            row.find('select').val('').trigger('change');
            row.find('input').val('');
            $('#order-items-table tbody').append(row);
            $('.select2-product').select2({ width: '100%' });
        });
        // Remove row
        $(document).on('click', '.remove-row', function() {
            if($('#order-items-table tbody tr').length > 1) {
                $(this).closest('tr').remove();
                calculateTotal();
            }
        });
        // Auto price fill on product select
        $(document).on('change', '.select2-product', function() {
            let price = $(this).find('option:selected').data('price') || 0;
            $(this).closest('tr').find('.price-input').val(price);
            calculateSubtotal($(this).closest('tr'));
            calculateTotal();
        });
        // Calculate subtotal and total
        $(document).on('input', '.price-input, .qty-input', function() {
            calculateSubtotal($(this).closest('tr'));
            calculateTotal();
        });
        function calculateSubtotal(row) {
            let price = parseFloat(row.find('.price-input').val()) || 0;
            let qty = parseInt(row.find('.qty-input').val()) || 1;
            row.find('.subtotal-input').val((price * qty).toFixed(2));
        }
        function calculateTotal() {
            let total = 0;
            $('.subtotal-input').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#total').val(total.toFixed(2));
        }
    });
</script>
@endsection
