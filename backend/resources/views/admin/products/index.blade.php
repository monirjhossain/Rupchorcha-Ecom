@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="form-row align-items-end">
                <div class="form-group col-md-4">
                    <label for="filter_name">Name</label>
                    <input type="text" name="name" id="filter_name" value="{{ request('name') }}" class="form-control" placeholder="Search by name">
                </div>
                <div class="form-group col-md-3">
                    <label for="filter_category">Category</label>
                    <select name="category_id" id="filter_category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="filter_brand">Brand</label>
                    <select name="brand_id" id="filter_brand" class="form-control">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-info btn-block">Filter</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Stock</th>
                        <th>SKU</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="Image" style="max-width: 60px; max-height: 60px;" class="img-thumbnail">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ ucfirst($product->status) }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ $product->brand->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            <nav>
                {{ $products->links('pagination::bootstrap-4') }}
            </nav>
        </div>
    </div>
</div>
@endsection
