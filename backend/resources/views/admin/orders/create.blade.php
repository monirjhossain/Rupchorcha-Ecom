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
                        <div class="row align-items-end mb-3" id="product-input-row">
                            <div class="form-group col-md-5 mb-2">
                                <label class="font-weight-bold" for="product-search">Product</label>
                                <input type="text" id="product-search" class="form-control" placeholder="Type product name..." autocomplete="off">
                                <input type="hidden" id="product-id" value="">
                                <div id="product-search-list" class="list-group position-absolute w-100" style="z-index: 1000; display: none;"></div>
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label class="font-weight-bold">Quantity</label>
                                <input type="number" id="input-quantity" class="form-control" min="1" value="1">
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label class="font-weight-bold">Unit Price</label>
                                <input type="number" id="input-unit-price" class="form-control" min="0" step="0.01">
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label class="font-weight-bold">Subtotal</label>
                                <input type="text" id="input-subtotal" class="form-control bg-light font-weight-bold" readonly>
                            </div>
                            <div class="form-group col-md-1 mb-2 text-center">
                                <button type="button" class="btn btn-info" id="add-product-btn"><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover bg-white" id="added-products-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
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

@push('scripts')
<script>
// Product data for autocomplete (server-side rendered)
const products = [
    @foreach(App\Models\Product::orderBy('name')->get() as $product)
        { id: {{ $product->id }}, name: @json($product->name), price: {{ $product->price }} },
    @endforeach
];

$(document).ready(function() {
    // Autocomplete for product search
    $('#product-search').on('input', function() {
        const query = $(this).val().toLowerCase();
        if (!query) {
            $('#product-search-list').hide();
            return;
        }
        const matches = products.filter(p => p.name.toLowerCase().includes(query));
        if (matches.length === 0) {
            $('#product-search-list').hide();
            return;
        }
        let html = '';
        matches.forEach(p => {
            html += `<button type="button" class="list-group-item list-group-item-action" data-id="${p.id}" data-name="${p.name}" data-price="${p.price}">${p.name} <span class='text-muted'>(৳${p.price})</span></button>`;
        });
        $('#product-search-list').html(html).show();
    });

    // Select product from dropdown
    $('#product-search-list').on('click', 'button', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const price = $(this).data('price');
        const qty = parseInt($('#input-quantity').val()) || 1;
        const subtotal = (qty * price).toFixed(2);
        // Add row to table with hidden fields
        const row = `<tr data-product-id="${id}">
            <td>
                <input type="hidden" name="product_id[]" value="${id}">
                <input type="hidden" name="quantity[]" value="${qty}">
                <input type="hidden" name="unit_price[]" value="${price}">
                ${name}
            </td>
            <td>${qty}</td>
            <td>৳${price.toFixed(2)}</td>
            <td class="row-subtotal">${subtotal}</td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button></td>
        </tr>`;
        $('#added-products-table tbody').append(row);
        // Optionally update total
        let total = 0;
        $('#added-products-table tbody tr').each(function() {
            total += parseFloat($(this).find('.row-subtotal').text()) || 0;
        });
        $('#total').val(total.toFixed(2));
        // Clear input fields
        $('#product-search').val('');
        $('#product-id').val('');
        $('#input-unit-price').val('');
        $('#input-subtotal').val('');
        $('#product-search-list').hide();
        $('#input-quantity').val('1');
    });
    });

    // Hide dropdown on blur (with delay for click)
    $('#product-search').on('blur', function() {
        setTimeout(() => $('#product-search-list').hide(), 200);
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
if (typeof jQuery === 'undefined') {
    alert('jQuery not loaded!');
}
$(document).ready(function() {
    console.log('Order create JS loaded');
    function updateInputSubtotal() {
        const qty = parseFloat($('#input-quantity').val()) || 0;
        const price = parseFloat($('#input-unit-price').val()) || 0;
        $('#input-subtotal').val((qty * price).toFixed(2));
    }
    function updateOrderTotal() {
        let total = 0;
        $('#added-products-table tbody tr').each(function() {
            total += parseFloat($(this).find('.row-subtotal').text()) || 0;
        });
        $('#total').val(total.toFixed(2));
    }
    function clearProductInputs() {
        $('#input-product-id').val('').trigger('change');
        $('#input-quantity').val('1');
        $('#input-unit-price').val('');
        $('#input-subtotal').val('');
    }
    $('.product-select').select2({
        placeholder: '🔍 Search or select product',
        allowClear: true,
        width: '100%'
    });
    // Update subtotal when quantity or price changes
    $('#input-quantity, #input-unit-price').on('input', updateInputSubtotal);

    // Autofill price and update subtotal when product changes
    $('#input-product-id').on('change', function() {
        var cost = $(this).find('option:selected').data('cost-price');
        if (typeof cost !== 'undefined' && cost !== null && cost !== '') {
            $('#input-unit-price').val(cost);
        } else {
            $('#input-unit-price').val('');
        }
        updateInputSubtotal();
    });

    // Also update subtotal if product is re-selected
    $('#input-product-id').on('select2:select', function() {
        var cost = $(this).find('option:selected').data('cost-price');
        if (typeof cost !== 'undefined' && cost !== null && cost !== '') {
            $('#input-unit-price').val(cost);
        } else {
            $('#input-unit-price').val('');
        }
        updateInputSubtotal();
    });
    $('#add-product-btn').on('click', function() {
        console.log('Add Product button clicked');
        const productId = $('#input-product-id').val();
        const productText = $('#input-product-id option:selected').text();
        const qty = parseInt($('#input-quantity').val()) || 1;
        const price = parseFloat($('#input-unit-price').val()) || 0;
        const subtotal = (qty * price).toFixed(2);
        if (!productId || qty < 1 || price < 0) {
            alert('Please select a product and enter valid quantity and price.');
            return;
        }
        // Add row to table with hidden inputs for form submission
        const row = `<tr data-product-id="${productId}">
            <td>
                <input type="hidden" name="product_id[]" value="${productId}">
                <input type="hidden" name="quantity[]" value="${qty}">
                <input type="hidden" name="unit_price[]" value="${price}">
                ${productText}
            </td>
            <td>${qty}</td>
            <td>৳${price.toFixed(2)}</td>
            <td class="row-subtotal">${subtotal}</td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button></td>
        </tr>`;
        $('#added-products-table tbody').append(row);
        updateOrderTotal();
        clearProductInputs();
    });
    $('#added-products-table').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        updateOrderTotal();
    });
    // Initial subtotal
    updateInputSubtotal();
});
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 48px;
        border-radius: 0.5rem;
        border: 1.5px solid #ced4da;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:hover {
        border-color: #ffc107;
        box-shadow: 0 0 0 2px #ffc10755;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 48px;
        color: #495057;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px;
    }
    .select2-search--dropdown .select2-search__field {
        border-radius: 0.5rem;
    }
    .select2-container {
        z-index: 9999 !important;
    }
    .select2-dropdown {
        z-index: 99999 !important;
    }
    .select2-results__options {
        max-height: 300px;
        overflow-y: auto;
    }
    #order-items-table th, #order-items-table td {
        vertical-align: middle;
        text-align: center;
    }
    #order-items-table th {
        background: #ffe082;
        color: #333;
        font-weight: 600;
    }
    #order-items-table td {
        background: #fffde7;
    }
    #add-product-btn {
        height: 40px;
        width: 100%;
        font-size: 1.1rem;
        border-radius: 0.5rem;
    }
    .card-header.bg-warning {
        background: linear-gradient(90deg, #ffe082 60%, #ffd54f 100%) !important;
        color: #333 !important;
    }
    .form-group label.font-weight-bold {
        font-size: 1.05rem;
        color: #333;
    }
</style>
@endpush
