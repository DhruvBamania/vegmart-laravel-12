<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;

//admin routes
Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');
Route::get('/adminProfile', [AdminController::class,'adminProfile'])->name('adminProfile');
Route::get('/customers', [AdminController::class,'customers'])->name('customers');
Route::get('/adminProducts', [AdminController::class,'products'])->name('products');
Route::post('/addProduct', [AdminController::class,'addProduct'])->name('addProduct');
Route::post('/addItem', [AdminController::class,'addItem'])->name('addItem');
Route::post('/updateItem/{id}', [AdminController::class,'updateItem'])->name('updateItem');
Route::delete('/itemDelete/{id}', [AdminController::class,'itemDelete'])->name('itemDelete');
Route::delete('/deleteCategory/{id}', [AdminController::class,'deleteCategory'])->name('deleteCategory');
Route::get('/changeStatus/{status}/{id}', [AdminController::class,'changeStatus'])->name('changeStatus');


// customer routes
Route::get('/', [PageController::class,'home'])->name('home');
Route::get('/shop', [PageController::class,'shop'])->name('shop');
Route::get('/cart', [PageController::class,'cart'])->name('cart');
Route::get('/checkout', [PageController::class,'checkout'])->name('checkout');
Route::get('/contact', [PageController::class,'contact'])->name('contact');
Route::get('/shop-detail', [PageController::class,'shop_detail'])->name('shop-detail');
Route::get('/404', [PageController::class,'notfound'])->name('404');
Route::get('/testimonial', [PageController::class,'testimonial'])->name('testimonial');
Route::get('/profile', [PageController::class,'profile'])->name('profile');
Route::get('/login', [PageController::class,'login'])->name('login');
Route::get('/logout', [PageController::class,'logout'])->name('logout');
Route::post('/loginUser', [PageController::class,'loginUser'])->name('loginUser');
Route::get('/register', [PageController::class,'register'])->name('register');
Route::post('/registerUser', [PageController::class,'registerUser'])->name('registerUser'); 
Route::post('/updateUser/{id}', [PageController::class,'updateUser'])->name('updateUser'); 


