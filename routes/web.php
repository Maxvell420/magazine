<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web test for your application. These
| test are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('cart')->group(function (){
    Route::get('',[MainController::class,'dashboard'])->name('main.dashboard');
    Route::get('cart',[MainController::class,'cart'])->name('main.cart');
    Route::post('checkout',[MainController::class,'checkout'])->name('main.checkout');
    Route::get('login',[UserController::class,'login'])->name('user.login');
    Route::get('user/create',[UserController::class,'create'])->name('user.create');
    Route::get('login',[UserController::class,'login'])->name('main.login');
    Route::get('logout',[UserController::class,'logout'])->name('main.logout');
    Route::post('user/save',[UserController::class,'save'])->name('user.save');
    Route::post('user/auth',[UserController::class,'auth'])->name('user.auth');
    Route::post('order/save',[OrderController::class,'save'])->name('order.save');
    Route::get('order/{order}/show',[MainController::class,'orderShow'])->name('order.show');
    Route::get('product/{product}/show',[MainController::class,'productShow'])->name('main.product');

    Route::middleware('auth')->group(function (){
        Route::get('favourites',[MainController::class,'favourites'])->name('main.favourites');
        Route::post('/product/{product}/dislike',[ProductController::class,'dislike'])->name('product.dislike');
        Route::get('adminka',[MainController::class,'adminBoard'])->name('main.admin');
        Route::post('/order{order}/edit',[OrderController::class,'edit'])->name('order.edit');
        Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
        Route::post('/product/{product}/like',[ProductController::class,'like'])->name('product.like');
        Route::get('product/{product}/edit',[MainController::class,'productEdit'])->name('product.edit');
        Route::post('product/{product}/update',[ProductController::class,'Update'])->name('product.update');
        Route::post('/product/save',[ProductController::class,'save'])->name('product.save');
        Route::post('/category/save',[CategoryController::class,'save'])->name('category.save');
        Route::post('/subcategory/save',[SubcategoryController::class,'save'])->name('subcategory.save');
        Route::get('/user/orders',[MainController::class,'orders'])->name('main.orders');
    });
});

Route::prefix('ru')->group(function () {
    Route::middleware('cart')->group(function (){
        Route::get('',[MainController::class,'dashboard'])->name('ru.main.dashboard');
        Route::get('cart',[MainController::class,'cart'])->name('ru.main.cart');
        Route::post('checkout',[MainController::class,'checkout'])->name('ru.main.checkout');
        Route::get('user/create',[UserController::class,'create'])->name('ru.user.create');
        Route::get('login',[UserController::class,'login'])->name('ru.main.login');
        Route::get('logout',[UserController::class,'logout'])->name('ru.main.logout');
        Route::post('order/save',[OrderController::class,'save'])->name('ru.order.save');
        Route::get('order/{order}/show',[MainController::class,'orderShow'])->name('ru.order.show');
        Route::get('product/{product}/show',[MainController::class,'productShow'])->name('ru.main.product');

        Route::middleware('auth')->group(function (){
            Route::get('favourites',[MainController::class,'favourites'])->name('ru.main.favourites');
            Route::get('adminka',[MainController::class,'adminBoard'])->name('ru.main.admin');
            Route::post('/order{order}/edit',[OrderController::class,'edit'])->name('ru.order.edit');
            Route::get('/product/create',[ProductController::class,'create'])->name('ru.product.create');
            Route::get('product/{product}/edit',[MainController::class,'productEdit'])->name('ru.product.edit');
            Route::get('/user/orders',[MainController::class,'orders'])->name('ru.main.orders');
        });
    });
});
