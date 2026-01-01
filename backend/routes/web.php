<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentSummaryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductDownloadController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserActivityLogController;
use App\Http\Controllers\WarehouseController;

Route::post('/admin/products/export', [ProductController::class, 'export'])->name('products.export');
// Inventory management UI
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
});

// Report routes
Route::get('/report/brand', [DashboardReportController::class, 'brandReport'])->name('report.brand');
Route::get('/report/brand/export', [DashboardReportController::class, 'exportBrandReport'])->name('report.brand.export');
Route::get('/report/category', [DashboardReportController::class, 'categoryReport'])->name('report.category');
Route::get('/report/category/export', [DashboardReportController::class, 'exportCategoryReport'])->name('report.category.export');
Route::get('/report/total', [DashboardReportController::class, 'totalReport'])->name('report.total');
Route::get('/report/total/export', [DashboardReportController::class, 'exportTotalReport'])->name('report.total.export');
Route::get('/report/max-products', [DashboardReportController::class, 'maxProductsReport'])->name('report.max_products');
Route::get('/report/max-products/export', [DashboardReportController::class, 'exportMaxProductsReport'])->name('report.max_products.export');

// Advanced Reports & Analytics
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/admin/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/admin/reports/sales/export/{type}', [ReportController::class, 'exportSales'])->name('reports.sales.export');
    Route::get('/admin/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/admin/reports/revenue/export/{type}', [ReportController::class, 'exportRevenue'])->name('reports.revenue.export');
    Route::get('/admin/reports/top-products', [ReportController::class, 'topProducts'])->name('reports.top_products');
    Route::get('/admin/reports/top-products/export/{type}', [ReportController::class, 'exportTopProducts'])->name('reports.top_products.export');
    Route::get('/admin/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('/admin/reports/customers/export/{type}', [ReportController::class, 'exportCustomers'])->name('reports.customers.export');
});

Route::get('/admin/users/activity-logs', [UserActivityLogController::class, 'index'])->name('users.activity_logs');
Route::get('/admin/users/{id}/activity-logs', [UserActivityLogController::class, 'show'])->name('users.activity_logs_user');
Route::get('/admin/payments/summary', [PaymentSummaryController::class, 'index'])->name('payments.summary');
Route::post('/admin/users/{id}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');
Route::post('/admin/users/{id}/message', [UserController::class, 'sendMessage'])->name('users.message');
Route::get('/admin/users/bulk-message', [UserController::class, 'bulkMessageForm'])->name('users.bulk_message_form');
Route::post('/admin/users/bulk-message', [UserController::class, 'sendBulkMessage'])->name('users.bulk_message');

// Supplier, Warehouse, and Purchase Order admin routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::resource('/admin/suppliers', SupplierController::class)->names('suppliers');
    Route::resource('/admin/warehouses', WarehouseController::class)->names('warehouses');
    Route::get('/admin/purchase-orders/{purchase_order}/pdf', [PurchaseOrderController::class, 'pdf'])->name('purchase_orders.pdf');
    Route::get('/admin/purchase-orders/{purchase_order}/preview', [PurchaseOrderController::class, 'show'])->name('purchase_orders.preview');
    Route::resource('/admin/purchase-orders', PurchaseOrderController::class)->names('purchase_orders');
    Route::get('/admin/purchase-orders/{purchase_order}/show', [PurchaseOrderController::class, 'showDetails'])->name('purchase_orders.showDetails');
    Route::post('/admin/purchase-orders/{purchase_order}/update-status', [PurchaseOrderController::class, 'updateStatus'])->name('purchase_orders.updateStatus');
    Route::post('/admin/purchase-orders/{purchase_order}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase_orders.approve');
    Route::post('/admin/purchase-orders/{purchase_order}/reject', [PurchaseOrderController::class, 'reject'])->name('purchase_orders.reject');
    Route::post('/admin/purchase-orders/{purchase_order}/cancel', [PurchaseOrderController::class, 'cancel'])->name('purchase_orders.cancel');
    Route::post('/admin/purchase-orders/{purchase_order}/receive-goods', [PurchaseOrderController::class, 'receiveGoods'])->name('purchase_orders.receiveGoods');
});

// Authentication routes
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// User management (admin)
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/admin/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/admin/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::get('/dashboard-report', [DashboardReportController::class, 'index'])->name('dashboard.report');
Route::get('/dashboard-report/export', [DashboardReportController::class, 'exportCsv'])->name('dashboard.report.export');

// Product module routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/products/bulk-import', [ProductController::class, 'showBulkImportForm'])->name('products.bulkImportForm');
    Route::post('/admin/products/bulk-import', [ProductController::class, 'bulkImport'])->name('products.bulkImport');
    Route::get('/admin/products/bulk-import-sample', [ProductController::class, 'bulkImportSample'])->name('products.bulkImportSample');
    // Stock movement routes
    Route::get('/admin/products/{product}/stock-movement', [\App\Http\Controllers\StockMovementController::class, 'create'])->name('products.stock_movement.create');
    Route::post('/admin/products/{product}/stock-movement', [\App\Http\Controllers\StockMovementController::class, 'store'])->name('products.stock_movement.store');

    Route::resource('/admin/orders', OrderController::class);
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/brands', BrandController::class);
    Route::resource('/admin/attributes', AttributeController::class);
});
Route::resource('/admin/attribute-values', AttributeValueController::class);
Route::resource('/admin/coupons', CouponController::class)->names('coupons');
Route::resource('discounts', DiscountController::class);


Route::resource('/admin/tags', TagController::class);
Route::resource('/admin/product-images', ProductImageController::class)->only(['index','create','store','destroy']);
Route::resource('/admin/product-downloads', ProductDownloadController::class)->only(['index','create','store','destroy']);

// Supplier, Warehouse, and Purchase Order admin routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::resource('/admin/suppliers', SupplierController::class)->names('suppliers');
    Route::resource('/admin/warehouses', WarehouseController::class)->names('warehouses');
    Route::get('/admin/purchase-orders/{purchase_order}/pdf', [PurchaseOrderController::class, 'pdf'])->name('purchase_orders.pdf');
    Route::resource('/admin/purchase-orders',PurchaseOrderController::class)->names('purchase_orders');
}); 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [\App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
