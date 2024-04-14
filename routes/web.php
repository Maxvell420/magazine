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
    Route::get('/', [MainController::class, 'index'])->name('root');
});
Route::middleware('cart')->prefix('en')->name('en.')->group(function (){
    Route::get('',[MainController::class,'dashboard'])->name('main.dashboard');
    Route::get('cart',[MainController::class,'cart'])->name('main.cart');
    Route::get('checkout',[MainController::class,'checkout'])->name('main.checkout');
    Route::get('login',[MainController::class,'login'])->name('main.login');
    Route::get('user/create',[MainController::class,'userCreate'])->name('user.create');
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
        Route::get('/product/create',[MainController::class,'productCreate'])->name('product.create');
        Route::post('/product/{product}/like',[ProductController::class,'like'])->name('product.like');
        Route::get('product/{product}/edit',[MainController::class,'productEdit'])->name('product.edit');
        Route::post('product/{product}/update',[ProductController::class,'Update'])->name('product.update');
        Route::post('/product/save',[ProductController::class,'save'])->name('product.save');
        Route::post('/category/save',[CategoryController::class,'save'])->name('category.save');
        Route::post('/subcategory/save',[SubcategoryController::class,'save'])->name('subcategory.save');
        Route::get('/user/orders',[MainController::class,'orders'])->name('main.orders');
//        new
        Route::get('/categories',[MainController::class,'categories'])->name('main.categories');
        Route::get('/category/{category}/show',[MainController::class,'categoryEdit'])->name('category.edit');
        Route::get('/subcategory/{subcategory}/show',[MainController::class,'subcategoryEdit'])->name('subcategory.edit');
        Route::get('/products',[MainController::class,'products'])->name('main.products');
        Route::get('/subcategories',[MainController::class,'subcategories'])->name('main.subcategories');
        Route::post('/category/{category}/update',[CategoryController::class,'update'])->name('category.update');
        Route::post('/subcategory/{subcategory}/update',[SubcategoryController::class,'update'])->name('subcategory.update');
    });
});

Route::middleware('cart')->prefix('ru')->name('ru.')->group(function (){
    Route::get('',[MainController::class,'dashboard'])->name('main.dashboard');
    Route::get('cart',[MainController::class,'cart'])->name('main.cart');
    Route::get('checkout',[MainController::class,'checkout'])->name('main.checkout');
    Route::get('login',[MainController::class,'login'])->name('main.login');
    Route::get('user/create',[MainController::class,'userCreate'])->name('user.create');
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
        Route::get('/product/create',[MainController::class,'productCreate'])->name('product.create');
        Route::post('/product/{product}/like',[ProductController::class,'like'])->name('product.like');
        Route::get('product/{product}/edit',[MainController::class,'productEdit'])->name('product.edit');
        Route::post('product/{product}/update',[ProductController::class,'Update'])->name('product.update');
        Route::post('/product/save',[ProductController::class,'save'])->name('product.save');
        Route::post('/category/save',[CategoryController::class,'save'])->name('category.save');
        Route::post('/subcategory/save',[SubcategoryController::class,'save'])->name('subcategory.save');
        Route::get('/user/orders',[MainController::class,'orders'])->name('main.orders');

        Route::get('/categories',[MainController::class,'categories'])->name('main.categories');
        Route::get('/products',[MainController::class,'products'])->name('main.products');
        Route::get('/subcategories',[MainController::class,'subcategories'])->name('main.subcategories');
        Route::post('/category/{category}/update',[CategoryController::class,'update'])->name('category.update');
        Route::post('/subcategory/{subcategory}/update',[SubcategoryController::class,'update'])->name('subcategory.update');

        Route::get('/categories',[MainController::class,'categories'])->name('main.categories');
        Route::get('/category/{category}/show',[MainController::class,'categoryEdit'])->name('category.edit');
        Route::get('/subcategory/{subcategory}/show',[MainController::class,'subcategoryEdit'])->name('subcategory.edit');
        Route::get('/products',[MainController::class,'products'])->name('main.products');
        Route::get('/subcategories',[MainController::class,'subcategories'])->name('main.subcategories');
        Route::post('/category/{category}/update',[CategoryController::class,'update'])->name('category.update');
        Route::post('/subcategory/{subcategory}/update',[SubcategoryController::class,'update'])->name('subcategory.update');
    });
});
Route::get('/dash',[\App\Http\Controllers\JSController::class,'dash'])->name('dash');
