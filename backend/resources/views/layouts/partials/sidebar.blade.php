<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
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
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Users Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="/admin/users">
            <i class="fas fa-users fa-fw"></i>
            <span>Users</span>
        </a>
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
    <!-- More sidebar items can be added here -->
</ul>
<!-- End of Sidebar -->
