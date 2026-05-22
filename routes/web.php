<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

//admin routes
Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');
Route::get('/adminProfile', [AdminController::class,'adminProfile'])->name('adminProfile');
Route::get('/customers', [AdminController::class,'customers'])->name('customers');
Route::get('/orders', [AdminController::class,'orders'])->name('orders');
Route::post('/admin/order-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.order.status');
Route::get('/adminProducts', [AdminController::class,'products'])->name('products');
Route::get('/adminContact', [AdminController::class,'contact'])->name('contact.us');
Route::post('/addProduct', [AdminController::class,'addProduct'])->name('addProduct');
Route::post('/addItem', [AdminController::class,'addItem'])->name('addItem');
Route::post('/updateItem/{id}', [AdminController::class,'updateItem'])->name('updateItem');
Route::delete('/itemDelete/{id}', [AdminController::class,'itemDelete'])->name('itemDelete');
Route::delete('/deleteCategory/{id}', [AdminController::class,'deleteCategory'])->name('deleteCategory');
Route::get('/changeStatus/{status}/{id}', [AdminController::class,'changeStatus'])->name('changeStatus'); 
Route::get('/admin/discounts', [DiscountController::class, 'index'])->name('admin.discounts');
Route::post('/admin/discounts/store', [DiscountController::class, 'store'])->name('admin.discounts.store');
Route::delete('/admin/discounts/{id}', [DiscountController::class, 'destroy'])->name('admin.discounts.delete');


// customer routes
Route::get('/', [PageController::class,'home'])->name('home');
Route::get('/shop', [PageController::class,'shop'])->name('shop');
/* Route::get('/cart', [PageController::class,'cart'])->name('cart'); */
Route::get('/checkout', [PageController::class,'checkout'])->name('checkout');
Route::get('/contact', [PageController::class,'contact'])->name('contact');
Route::get('/shop-detail', [PageController::class,'shop_detail'])->name('shop-detail');
Route::get('/404', [PageController::class,'notfound'])->name('404');
Route::get('/testimonial', [PageController::class,'testimonial'])->name('testimonial');
Route::get('/profile', [PageController::class,'profile'])->name('profile');

// Login
Route::get('/login', [PageController::class,'login'])->name('login');
Route::get('/logout', [PageController::class,'logout'])->name('logout');
Route::post('/loginUser', [PageController::class,'loginUser'])->name('loginUser');

//OTP
Route::get('/verify-otp', function() {return view('pages.otp-verify');})->name('otp.verify');

Route::post('/verify-otp', [PageController::class, 'verifyOTP'])->name('otp.verify.post');

// Google Auth Routes
Route::get('/auth/google', [PageController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [PageController::class, 'handleGoogleCallback']);

Route::get('/register', [PageController::class,'register'])->name('register');
Route::post('/registerUser', [PageController::class,'registerUser'])->name('registerUser'); 
Route::post('/updateUser/{id}', [PageController::class,'updateUser'])->name('updateUser'); 

Route::post('/adminContact', [PageController::class,'contactForm'])->name('contactUs.submit');
Route::post('/contactUpdate', [PageController::class,'contactStatus'])->name('contactStatus.update');

Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware(['auth'])->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
    Route::get('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order-success/{order_number}', [OrderController::class, 'success'])->name('order.success');
    Route::post('/order/cancel/{id}', [PageController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/order/details/{id}', [PageController::class, 'orderDetails'])->name('order.details');
    Route::post('/razorpay/prepare', [OrderController::class, 'processRazorpay'])->name('razorpay.prepare');
    Route::get('/view-orders',[PageController::class,'viewOrders'])->name('view.orders');
});



