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
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('',[MainController::class,'dashboard'])->name('main.dashboard')->middleware('cart');
Route::get('cart',[MainController::class,'cart'])->name('main.cart')->middleware('cart');
Route::post('checkout',[MainController::class,'checkout'])->name('main.checkout')->middleware('cart');;
Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
Route::post('/product/save',[ProductController::class,'save'])->name('product.save');
Route::post('/subcategory/save',[CategoryController::class,'save'])->name('category.save');
Route::post('/category/save',[SubcategoryController::class,'save'])->name('subcategory.save');
Route::get('js',[TestController::class,'test']);


Route::get('user/create',[UserController::class,'create'])->name('user.create');
Route::get('login',[UserController::class,'login'])->name('user.login');
Route::get('logout',[UserController::class,'logout'])->name('user.logout');
Route::post('user/save',[UserController::class,'save'])->name('user.save');
Route::post('user/auth',[UserController::class,'auth'])->name('user.auth');
Route::post('order/save',[OrderController::class,'save'])->name('order.save');
Route::get('order/{order}/show',[MainController::class,'orderShow'])->name('order.show');
Route::get('/user/orders',[MainController::class,'orders'])->name('main.orders');
Route::get('favourites',[MainController::class,'favourites'])->name('main.favourites');
Route::get('product/{product}/show',[MainController::class,'productShow'])->name('main.product');
Route::post('/product/{product}/like',[ProductController::class,'like'])->name('product.like');
Route::post('/product/{product}/dislike',[ProductController::class,'dislike'])->name('product.dislike');
