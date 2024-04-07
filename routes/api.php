<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserConTroller;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\GBController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Phần User
Route::post('login', [UserController::class, 'getUser']);
Route::post('loginAdmin', [UserController::class, 'getAdmin']);
Route::get('getUser', [UserController::class, 'indexUser']);
Route::get('getEmploy', [UserController::class, 'indexEmploy']);
Route::post('addEmploy', [UserController::class, 'addEmploy']); 
Route::get('getArchive', [UserConTroller::class, 'archive']);
Route::get('restore/{id}', [UserConTroller::class, 'restore']);
Route::post('changePass', [UserConTroller::class, 'changePass']);
Route::apiResource('user', UserConTroller::class);

// Phần Màu Sắc
Route::apiResource('color', ColorController::class);

// Phần Dung Lượng
Route::apiResource('dungluong', GBController::class);
// Phần Menu 
Route::apiResource('menu', MenuController::class);

// Phần Products 
Route::apiResource('product', ProductController::class);

// Phần cart
Route::apiResource('cart', CartController::class);

// Phần đơn hàng 
Route::apiResource('donhang', DonHangController::class);





