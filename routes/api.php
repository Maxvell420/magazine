<?php

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API test for your application. These
| test are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('cart')->prefix('en')->name('en.')->group(function (){
    Route::post('/ajax/dashboard', [MainController::class, 'ajaxDashboard'])->name('main.ajaxDashboard');
});

Route::middleware('cart')->prefix('ru')->name('ru.')->group(function (){
    Route::post('/ajax/dashboard', [MainController::class, 'ajaxDashboard'])->name('main.ajaxDashboard');
});
