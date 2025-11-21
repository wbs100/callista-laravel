<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CustomRequestController;
use App\Http\Controllers\ConsultationRequestController;
use App\Http\Controllers\ProjectInquiryController;

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
Route::get('/run-migrations', function () {
    try {
        Artisan::call('optimize:clear');
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Migrations and seeders ran successfully.',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/', function () {
    $featuredProducts = App\Models\Product::with('images')
        ->where('stock_status', '!=', 'out_of_stock')
        ->orderBy('rating', 'desc')
        ->orderBy('created_at', 'desc')
        ->take(12)  // Increased to show more products for better filtering
        ->get();
        
    $categories = App\Models\Product::select('type')
        ->whereNotNull('type')
        ->distinct()
        ->pluck('type')
        ->take(6);
        
    return view('public-site.home', compact('featuredProducts', 'categories'));
})->name('home');

Route::get('/marketplace', function () {
    $products = App\Models\Product::with('images')
        ->where('stock_status', '!=', 'out_of_stock')
        ->orderBy('created_at', 'desc')
        ->paginate(12);
        
    $categories = App\Models\Product::select('type')
        ->whereNotNull('type')
        ->distinct()
        ->pluck('type');
        
    return view('public-site.marketplace', compact('products', 'categories'));
})->name('marketplace');


Route::get('/customize', [CustomRequestController::class, 'index'])->name('customize');
Route::post('/customize', [CustomRequestController::class, 'store'])->name('customize.store');


Route::get('/interior-design', function () {
    return view('public-site.interior-design');
})->name('interior-design');


Route::get('/about', function () {
    return view('public-site.about');
})->name('about');

Route::get('/contact', function () {
    return view('public-site.contact');
})->name('contact');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

// Product API routes for AJAX
Route::get('/api/products', [ProductController::class, 'getProducts'])->name('api.products');
Route::get('/api/products/{id}', [ProductController::class, 'getProduct'])->name('api.product');
Route::get('/api/categories', [ProductController::class, 'getCategories'])->name('api.categories');

// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
Route::get('/cart/total', [CartController::class, 'getTotal'])->name('cart.total');
Route::get('/cart/table', [CartController::class, 'getTable'])->name('cart.table');
Route::get('/cart/list', [CartController::class, 'getList'])->name('cart.list');

// Wishlist routes
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');
Route::get('/wishlist/total', [WishlistController::class, 'getTotal'])->name('wishlist.total');

Route::prefix('checkout')->group(function () {
    Route::get('/', [PaymentController::class, 'show'])->name('checkout.show');
    Route::post('/store', [PaymentController::class, 'store'])->name('checkout.store');

    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
});

// Admin Login Route
Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Main dashboard route - redirects based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            // run method "migrateSessionToDatabase" in CartController / WishlistController
            (new CartController)->migrateSessionToDatabase($user->id);
            (new WishlistController)->migrateSessionToDatabase($user->id);
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');
    
    // User Dashboard
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    
    // Admin Dashboard (with admin check)
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    
    // Order management routes
    Route::get('/admin/orders/{order}/details', [AdminController::class, 'orderDetails'])->name('admin.orders.details');
    Route::put('/admin/orders/{order}/update-status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    Route::delete('/admin/orders/{order}', [AdminController::class, 'destroyOrder'])->name('admin.orders.destroy');
    
    // Product CRUD routes
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    
    // Custom Request routes
    Route::get('/admin/custom-requests', [CustomRequestController::class, 'adminIndex'])->name('admin.custom-requests');
    Route::get('/admin/custom-requests/{id}', [CustomRequestController::class, 'show'])->name('admin.custom-requests.show');
    Route::get('/admin/custom-requests/{id}/edit', [CustomRequestController::class, 'edit'])->name('admin.custom-requests.edit');
    Route::put('/admin/custom-requests/{id}', [CustomRequestController::class, 'update'])->name('admin.custom-requests.update');
    Route::delete('/admin/custom-requests/{id}', [CustomRequestController::class, 'destroy'])->name('admin.custom-requests.destroy');
});

// Consultation Request route
Route::post('/consultation-request', [ConsultationRequestController::class, 'store'])->name('consultation-request.store');
Route::post('/project-inquiry', [ProjectInquiryController::class, 'store'])->name('project-inquiry.store');
