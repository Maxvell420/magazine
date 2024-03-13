<?php

use App\Http\Controllers\HouseController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ComplaintController;
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
Route::get('',[UserController::class,'dashboard'])->name('user.dashboard');
Route::get('/login',[UserController::class,'login'])->name('login');
Route::get('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/user-create',[UserController::class,'create'])->name('user.create');
Route::post('user-save',[UserController::class,'save'])->name('user.save');
Route::post('auth',[UserController::class,'auth'])->name('auth');
Route::get('house/{house}/show',[HouseController::class,'show'])->name('house.show');
Route::get('/about',[UserController::class,'about'])->name('user.project');

Route::middleware('auth')->group(function (){
    Route::get('/userFrozen',[UserController::class,'frozen'])->name('user.frozen');
    Route::get('chat/{house}/show/{chat?}',[\App\Http\Controllers\ChatController::class,'show'])->name('chat.show')->middleware('auth');

    Route::middleware('frozen')->group(function (){
        Route::post('/messageCreate/{chat}}',[\App\Http\Controllers\ChatController::class,'messageCreate'])->name('message.create');
        Route::get('/complaint/{house}/create',[ComplaintController::class,'create'])->name('complaint.create');
        Route::post('/complaint/{house}/save',[ComplaintController::class,'save'])->name('complaint.save');
        Route::get('/houseCreate',[HouseController::class,'create'])->name('house.create');
        Route::post('/houseSave',[HouseController::class,'save'])->name('house.save');
        Route::post('/houseConfirm',[HouseController::class,'confirmation'])->name('house.confirm');
    });
    Route::get('/userShow',[UserController::class,'show'])->name('user.show');
    Route::get('/watchlist',[WatchlistController::class,'show'])->name('watchlist.show');
    Route::post('favouriteRemove/{id}',[WatchlistController::class,'remove'])->name('favourite.remove');
    Route::post('favouriteAdd/{id}',[WatchlistController::class,'add'])->name('favourite.add');
    Route::get('/chatsShow',[UserController::class,'chats'])->name('chats.show');
    Route::get('/houses/show/{user?}',[UserController::class,'houses'])->name('user.houses');

    Route::middleware('admin')->group(function (){
        Route::get('/filter',[RoleController::class,'filter'])->name('admin.filter');
        Route::post('/userBan/{user}',[RoleController::class,'userBan'])->name('user.ban');
        Route::post('/userUnfreeze/{user}',[RoleController::class,'userUnfreeze'])->name('user.unfreeze');
        Route::get('/admin/statistics',[RoleController::class,'statistics'])->name('admin.statistics');
        Route::get('/admin/frozen',[RoleController::class,'frozen'])->name('admin.frozen');
    });
    Route::middleware('owner')->group(function (){
        Route::post('/houseDelete/{house}',[HouseController::class,'houseDelete'])->name('house.delete');
        Route::post('/house/{house}/archive',[HouseController::class,'archive'])->name('house.archive');
        Route::post('/house/{house}/unzip',[HouseController::class,'unzip'])->name('house.unzip');
        Route::post('/house/{house}/update',[HouseController::class,'update'])->name('house.update');
        Route::post('/photo/{photo}/delete',[HouseController::class,'photoDelete'])->name('photo.delete');
    });
});
Route::get('/migrate', function () {
    Artisan::call('migrate --seed');
    return 'Миграции успешно выполнены';
});
Route::get('js',[\App\Http\Controllers\JSController::class,'JS'])->name('js');
