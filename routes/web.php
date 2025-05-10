<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/users', [AuthController::class, 'indexShow'])->name('users.index');
Route::get('/news', [NewsController::class, 'indexShow'])->name('news.index');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/shopping', [ShoppingController::class, 'index'])->name('shopping.index');

