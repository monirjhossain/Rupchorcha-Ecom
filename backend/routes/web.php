<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Authentication routes
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// User management (admin)
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');

Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/admin/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::post('/admin/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');

// Product module routes
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductDownloadController;

Route::get('/admin/products/bulk-import', [ProductController::class, 'showBulkImportForm'])->name('products.bulkImportForm');
Route::post('/admin/products/bulk-import', [ProductController::class, 'bulkImport'])->name('products.bulkImport');
Route::get('/admin/products/bulk-import-sample', [ProductController::class, 'bulkImportSample'])->name('products.bulkImportSample');
Route::resource('/admin/products', ProductController::class);
Route::resource('/admin/categories', CategoryController::class);
Route::resource('/admin/brands', BrandController::class);
Route::resource('/admin/attributes', AttributeController::class);
Route::resource('/admin/attribute-values', AttributeValueController::class);
Route::resource('/admin/tags', TagController::class);
Route::resource('/admin/product-images', ProductImageController::class)->only(['index','create','store','destroy']);
Route::resource('/admin/product-downloads', ProductDownloadController::class)->only(['index','create','store','destroy']);

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

Route::get('/admin', function () {
    return view('admin.dashboard');
});
