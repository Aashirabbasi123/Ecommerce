<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\productController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
    /*
    |--------------------------------------------------------------------------
    | Landing Route: '/'
    |--------------------------------------------------------------------------
    | Redirects based on auth status
    */

    Route::get('/', function () {
        $user = Auth::user();
        if ($user && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif ($user) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    })->name('home');

    // |--------------------------------------------------------------------------
    // | Admin Routes (Requires auth + admin middleware)
    // |--------------------------------------------------------------------------
    // */
    Route::middleware(['auth:admin', 'admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
////----------------==============Coupon Code ==========---------------------------\\\
Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
Route::get('/admin/add_coupons', [AdminController::class, 'add_coupons'])->name('admin.add_coupons');
Route::post('/admin/coupon/store', [AdminController::class, 'coupon_store'])->name('admin.coupon.store');
Route::get('/admin/coupon/edit/{id}', [AdminController::class, 'edit_coupon'])->name('admin.coupon.edit');
Route::put('/admin/coupon/update/{id}', [AdminController::class, 'update_coupon'])->name('admin.coupon.update');
Route::delete('/admin/coupon/{id}/delete', [AdminController::class, 'delete_coupon'])->name('admin.coupon.delete');

////================---------------Slides ===================----------------------------\\\
Route::get('/admin/slides', [SlideController::class,'slides'])->name('admin.slides');
Route::get('/admin/add_slider', [SlideController::class,'add_slider'])->name('admin.add_slider');
Route::post('/admin/slide/store', [SlideController::class, 'slide_store'])->name('admin.slide.store');
Route::get('/admin/slide/edit/{id}', [SlideController::class, 'edit_slide'])->name('admin.slide.edit');
Route::put('/admin/slide/update/{id}', [SlideController::class, 'update_slide'])->name('admin.slide.update');
Route::delete('/admin/slide/{id}/delete', [SlideController::class, 'delete_slide'])->name('admin.slide.delete');


// Login routes (probably outside middleware) and Brand Routes ///
Route::get('/login1', [AuthenticatedSessionController::class, 'adminLoginForm'])->name('auth.login1');
Route::post('/login1', [AuthenticatedSessionController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthenticatedSessionController::class, 'adminDestroy'])->name('admin.logout');

Route::get('/admin/brand', [BrandController::class, 'brands'])->name('admin.brand');
Route::get('/admin/add_brand', [BrandController::class, 'add_brand'])->name('admin.add_brand');
Route::post('/admin/brand/store', [BrandController::class, 'brand_store'])->name('admin.brand.store');
Route::get('/admin/brand/edit/{id}', [BrandController::class, 'edit_brand'])->name('admin.brand.edit');
Route::put('/admin/brand/update/{id}', [BrandController::class, 'update_brand'])->name('admin.brand.update');
Route::get('/admin/brand/{id}/delete', [BrandController::class, 'delete_brand'])->name('admin.brand.delete');
Route::delete('/admin/brand/{id}/delete', [BrandController::class, 'delete_brand'])->name('admin.brand.delete');
                    ///----------------categeory ROutes--------------------------------\\\
Route::get('/admin/category', [CategoryController::class, 'categories'])->name('admin.categories');
Route::get('/admin/add_category', [CategoryController::class, 'add_category'])->name('admin.add_category');
Route::post('/admin/category/store', [CategoryController::class, 'category_store'])->name('admin.category.store');
Route::get('/admin/category/edit/{id}', [CategoryController::class, 'edit_category'])->name('admin.category.edit');
Route::put('/admin/category/update/{id}', [CategoryController::class, 'update_category'])->name('admin.category.update');
Route::get('/admin/category/{id}/delete', [CategoryController::class, 'delete_category'])->name('admin.category.delete');
Route::delete('/admin/category/{id}/delete', [CategoryController::class, 'delete_category'])->name('admin.category.delete');
///-----------------Product Routes --------------------------------\\\\
Route::get('/admin/products', [productController::class, 'products'])->name('admin.products');
Route::get('/admin/add_product', [productController::class, 'add_product'])->name('admin.add_product');
Route::post('/admin/product/store', [productController::class, 'product_store'])->name('admin.product.store');
Route::get('/admin/product/edit/{id}', [productController::class, 'product_edit'])->name('admin.product.edit');
Route::put('/admin/product/update/{id}', [productController::class, 'update_product'])->name('admin.product.update');
Route::get('/admin/product/{id}/delete', [productController::class, 'delete_product'])->name('admin.product.delete');
Route::delete('/admin/product/{id}/delete', [productController::class, 'delete_product'])->name('admin.product.delete');
/////--------------=============----Shop Page -------------==================--------------------\\\
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');;
Route::get('/shop/detail/{product_slug}', [ShopController::class, 'detail'])->name('detailpage');
////////////////////////===================Order Route =================================\\\\\\\\\\\\\\\\

Route::get('/admin/orders',[AdminController::class,'order'])->name('admin.order');
Route::get('/admin/order/{order_id},detail',[AdminController::class,'order_detail'])->name('admin.order-detail');
Route::put('/admin/order/update-status',[AdminController::class,'update_order_status'])->name('admin.order.status.update');

////================-=========----------cart route ===============--------------------\\\\\\
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('add.cart');
Route::put('/cart/increase/{id}', [CartController::class, 'increase_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease/{id}', [CartController::class, 'decrease_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/remove/', [CartController::class, 'empty_cart'])->name('cart.empty');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/cart/store', [CartController::class, 'apply_coupon_code'])->name('apply.coupon.code');
Route::delete('/cart/remove_code', [CartController::class, 'remove_coupon_code'])->name('remove_coupon_code');
Route::post('/place-an-order', [CartController::class, 'place_an_order'])->name('place.an.order');
Route::get('/order/confirm', [CartController::class, 'order_confirm'])->name('card.confirm.order');


/// ----------------------================ Wishlist Controller ============================------------------\\\\
Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('add.wishlist');
Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove_from_wishlist'])->name('wishlist.remove');
Route::delete('/wishlist/remove/', [WishlistController::class, 'empty_wishlist'])->name('wishlist.empty');
Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move.cart');


/// ----------------====================== User Controller ===================---------------------------\\\
Route::get('/contact', [UserController::class, 'contact'])->name('contact');
Route::get('/contact/store', [UserController::class, 'contact_store'])->name('user.contact.store');


/*
|--------------------------------------------------------------------------
| User Routes (Protected: auth + user role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'user'])->group(function () {
    Route::get('/useraccount', [UserController::class, 'useraccount'])->name('useraccount');
    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-order-detail/{order_id}', [UserController::class, 'order_detail'])->name('user.order-detail');

});

/*
|--------------------------------------------------------------------------
| Public Routes (No auth required)
|--------------------------------------------------------------------------
*/
Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::put('/account-order/cancel-order', [UserController::class, 'order_cancel'])->name('user.cancel.order');

/*
|--------------------------------------------------------------------------
| Profile Routes (All Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (from Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
