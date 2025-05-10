<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\DashboardController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/news-list', [NewsController::class, 'index']);
Route::post('/news-store', [NewsController::class, 'store']);


Route::post('signupOrLogin', [AuthController::class, 'signupOrLogin']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);


Route::prefix('movies')->group(function () {
    Route::get('/list', [MovieController::class, 'index']);
    Route::post('/add', [MovieController::class, 'store']);
    Route::get('{id}', [MovieController::class, 'show']);
    Route::put('{id}', [MovieController::class, 'update']);
    Route::delete('{id}', [MovieController::class, 'destroy']);
});



Route::prefix('shopping')->group(function () {
    Route::get('/list', [ShoppingController::class, 'index']);
    Route::post('/', [ShoppingController::class, 'store']);
    Route::get('/{id}', [ShoppingController::class, 'show']);
    Route::put('/{id}', [ShoppingController::class, 'update']);
    Route::delete('/{id}', [ShoppingController::class, 'destroy']);
});