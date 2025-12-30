<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sidebar-sticky" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Dashboard Report -->
    <!-- Nav Item - Report -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
            <i class="fas fa-chart-bar fa-fw"></i>
            <span>Report</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingReport" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('report.brand') }}">Brand Wise Sales</a>
                <a class="collapse-item" href="{{ route('report.category') }}">Category Wise Sales</a>
                <a class="collapse-item" href="{{ route('report.total') }}">Total Sales</a>
                <a class="collapse-item" href="{{ route('report.max_products') }}">Max Selling Products</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Users Nav Item -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
            <i class="fas fa-users fa-fw"></i>
            <span>Users</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/users">User List</a>
                <a class="collapse-item" href="{{ route('users.activity_logs') }}">User Activity Log</a>
            </div>
        </div>
    </li>
    <!-- Inventory Section -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Inventory</div>
    <!-- Inventory Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventory" aria-expanded="true" aria-controls="collapseInventory">
            <i class="fas fa-warehouse fa-fw"></i>
            <span>Inventory</span>
        </a>
        <div id="collapseInventory" class="collapse" aria-labelledby="headingInventory" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/products">Products</a>
                <a class="collapse-item" href="/admin/products/create">Create Product</a>
                <a class="collapse-item" href="/admin/categories">Categories</a>
                <a class="collapse-item" href="/admin/brands">Brands</a>
                <a class="collapse-item" href="/admin/attributes">Attributes</a>
                <a class="collapse-item" href="/admin/tags">Product Tags</a>
                <a class="collapse-item" href="/admin/products/bulk-import">Product Bulk Import</a>
            </div>
        </div>
    </li>
    <!-- Order Management Section -->
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="false" aria-controls="collapseOrders">
            <i class="fas fa-shopping-cart fa-fw"></i>
            <span>Order Management</span>
        </a>
        <div id="collapseOrders" class="collapse" aria-labelledby="headingOrders" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('orders.index') }}">Orders</a>
                <a class="collapse-item" href="{{ route('coupons.index') }}">Coupon</a>
                <a class="collapse-item" href="{{ route('discounts.index') }}">Discount</a>
                <!-- Future: Add more order-related links here -->
            </div>
        </div>
    </li>
    </li>
    <!-- Accounts Section -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Accounts</div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('payments.summary') }}">
            <i class="fas fa-wallet fa-fw"></i>
            <span>Payment Summary</span>
        </a>
    </li>
    <!-- More sidebar items can be added here -->
</ul>
<!-- End of Sidebar -->
