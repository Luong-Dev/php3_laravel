<?php

use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductAttributeCategoryController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductAttributeProductDetailController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomePageController::class, 'index']);

// không cần đăng nhập
Route::group(['prefix' => 'products'], function () {
    Route::get('', [ProductController::class, 'userIndex']);
    Route::get('details/{id}', [ProductDetailController::class, 'userDetail']);
    // Route::get('deleted-force/{id}', [ProductAttributeController::class, 'forceDeleted']);
});

// đăng nhập, xác thực
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    // Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'carts'], function () {
        // Route::get('', [CartController::class, 'userCart']);
        Route::post('', [CartController::class, 'userCart']);
        Route::get('view', [CartController::class, 'userCartView']);
        // Route::get('checkout', [CartController::class, 'userCartCheckout']);
        Route::get('delete/{id}', [CartController::class, 'destroy']);
        // Route::get('edit/{id}', [CartController::class, 'edit']);
        Route::get('update/{productDetailId}/{quantity}', [CartController::class, 'update']);
    });

    Route::group(['prefix' => 'vouchers'], function () {
        Route::post('checkout', [VoucherController::class, 'checkVoucher']);
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::post('store', [OrderController::class, 'store']);
    });
});





// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');

// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');
// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified']);

// Route::get('/admin/product_categories', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');
// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');
// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');
// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');
// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');

// Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified','admin'])->name('dashboard');

// đăng nhập, xác thực, check role
Route::middleware('auth', 'verified', 'admin')->group(function () {
    Route::get('/admin', function () {
        return view('admin.home');
    });

    Route::get('/admin/accounts', [UserController::class, 'index'])->name('admin.account.index');
    Route::get('/admin/accounts/create', [UserController::class, 'create']);
    Route::post('/admin/accounts/create', [UserController::class, 'store']);
    // Route::post('/admin/accounts/create', [UserController::class, 'create']);
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'admin/product-categories'], function () {
        Route::get('', [ProductCategoryController::class, 'index']);
        Route::get('create', [ProductCategoryController::class, 'create']);
        Route::post('store', [ProductCategoryController::class, 'store']);
        Route::get('edit/{id}', [ProductCategoryController::class, 'edit']);
        Route::post('update/{id}', [ProductCategoryController::class, 'update']);
        Route::get('delete/{id}', [ProductCategoryController::class, 'destroy']);
        Route::get('deleted-list', [ProductCategoryController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [ProductCategoryController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [ProductCategoryController::class, 'forceDeleted']);
    });

    Route::group(['prefix' => 'admin/products'], function () {
        Route::get('', [ProductController::class, 'index']);
        Route::get('create', [ProductController::class, 'create']);
        Route::post('store', [ProductController::class, 'store']);
        Route::get('edit/{id}', [ProductController::class, 'edit']);
        Route::post('update/{id}', [ProductController::class, 'update']);
        Route::get('delete/{id}', [ProductController::class, 'destroy']);
        Route::get('deleted-list', [ProductController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [ProductController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [ProductController::class, 'forceDeleted']);
    });

    Route::group(['prefix' => 'admin/product-details'], function () {
        Route::get('', [ProductDetailController::class, 'index']);
        Route::get('/detail/{id}', [ProductDetailController::class, 'detail']);
        // Route::get('create/{id}', [ProductDetailController::class, 'create']);
        Route::get('create-no-attribute/{id}', [ProductDetailController::class, 'createNoAttribute']);
        Route::post('store-no-attribute/{id}', [ProductDetailController::class, 'storeNoAttribute']);
        Route::get('create-option-have-attribute/{id}', [ProductDetailController::class, 'createOptionHaveAttribute']);
        Route::post('store-option-have-attribute/{id}', [ProductDetailController::class, 'storeOptionHaveAttribute']);
        Route::get('create-have-attribute/{id}', [ProductDetailController::class, 'createHaveAttribute']);
        Route::post('store-have-attribute/{id}', [ProductDetailController::class, 'storeHaveAttribute']);
        // Route::post('store', [ProductDetailController::class, 'store']);
        Route::get('edit/{proId}/{detailId}', [ProductDetailController::class, 'edit']);
        Route::post('update/{proId}/{detailId}', [ProductDetailController::class, 'update']);
        Route::get('delete-all/{id}', [ProductDetailController::class, 'destroyAll']);
        Route::get('delete-one/{productId}/{productDetail}', [ProductDetailController::class, 'destroyOne']);
        // Route::get('delete/{id}', [ProductDetailController::class, 'destroy']);
        Route::get('deleted-list', [ProductDetailController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [ProductDetailController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [ProductDetailController::class, 'forceDeleted']);
    });

    Route::group(['prefix' => 'admin/product-images'], function () {
        Route::get('', [ProductImageController::class, 'index']);
        Route::get('create/{id}', [ProductImageController::class, 'create']);
        Route::post('store', [ProductImageController::class, 'store']);
        Route::get('edit/{id}', [ProductImageController::class, 'edit']);
        Route::get('productImage/{id}', [ProductImageController::class, 'productImage']);
        Route::post('update', [ProductImageController::class, 'update']);
        Route::get('delete/{id}', [ProductImageController::class, 'destroy']);
        Route::get('deleted-list', [ProductImageController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [ProductImageController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [ProductImageController::class, 'forceDeleted']);
    });

    Route::group(['prefix' => 'admin/banners'], function () {
        Route::get('', [BannerController::class, 'index']);
        Route::get('create', [BannerController::class, 'create']);
        Route::get('editlevel', [BannerController::class, 'editlevel']);
        Route::post('store', [BannerController::class, 'store']);
        Route::post('updateLevel', [BannerController::class, 'updateLevel']);
        Route::get('edit/{id}', [BannerController::class, 'edit']);
        Route::post('update', [BannerController::class, 'update']);
        Route::get('delete/{id}', [BannerController::class, 'destroy']);
        Route::get('deleted-list', [BannerController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [BannerController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [BannerController::class, 'forceDeleted']);
    });

    Route::group(['prefix' => 'admin/vouchers'], function () {
        Route::get('', [VoucherController::class, 'index']);
        Route::get('create', [VoucherController::class, 'create']);
        Route::post('store', [VoucherController::class, 'store']);
        Route::get('edit/{id}', [VoucherController::class, 'edit']);
        Route::post('update/{id}', [VoucherController::class, 'update']);
        Route::get('delete/{id}', [VoucherController::class, 'destroy']);
        Route::get('deleted-list', [VoucherController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [VoucherController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [VoucherController::class, 'forceDeleted']);
    });

    // route Category Product Attribute Category
    Route::group(['prefix' => 'admin/product-attribute-categories/'], function () {
        Route::get('', [ProductAttributeCategoryController::class, 'index']);
        Route::get('create', [ProductAttributeCategoryController::class, 'create']);
        Route::post('store', [ProductAttributeCategoryController::class, 'store']);
        Route::get('edit/{id}', [ProductAttributeCategoryController::class, 'edit']);
        Route::post('update/{id}', [ProductAttributeCategoryController::class, 'update']);
        Route::get('delete/{id}', [ProductAttributeCategoryController::class, 'destroy']);
        Route::get('deleted-list', [ProductAttributeCategoryController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [ProductAttributeCategoryController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [ProductAttributeCategoryController::class, 'forceDeleted']);
    });

    // route Category Product Attribute
    Route::group(['prefix' => 'admin/product-attributes/'], function () {
        Route::get('', [ProductAttributeController::class, 'index']);
        Route::get('create', [ProductAttributeController::class, 'create']);
        Route::post('store', [ProductAttributeController::class, 'store']);
        Route::get('edit/{id}', [ProductAttributeController::class, 'edit']);
        Route::post('update/{id}', [ProductAttributeController::class, 'update']);
        Route::get('delete/{id}', [ProductAttributeController::class, 'destroy']);
        Route::get('deleted-list', [ProductAttributeController::class, 'listDeleted']);
        Route::get('deleted-restore/{id}', [ProductAttributeController::class, 'restoreDeleted']);
        Route::get('deleted-force/{id}', [ProductAttributeController::class, 'forceDeleted']);
    });

    Route::group(['prefix' => 'admin/product-attribute-product-detail'], function () {
        Route::get('index/{id}', [ProductAttributeProductDetailController::class, 'index']);
        Route::get('create/{id}', [ProductAttributeProductDetailController::class, 'create']);
        Route::post('store/{id}', [ProductAttributeProductDetailController::class, 'store']);
        // Route::get('edit/{id}', [ProductAttributeProductDetailController::class, 'edit']);
        // Route::post('update/{id}', [ProductAttributeProductDetailController::class, 'update']);
        // Route::get('delete-all/{productDetailId}/{productAttributeId}/', [ProductAttributeProductDetailController::class, 'destroy']);
        // Route::get('deleted-list', [ProductAttributeProductDetailController::class, 'listDeleted']);
        // Route::get('deleted-restore/{id}', [ProductAttributeProductDetailController::class, 'restoreDeleted']);
        // Route::get('deleted-force/{id}', [ProductAttributeProductDetailController::class, 'forceDeleted']);
    });
});



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
