<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// User Authentication
Route::get('/login', [AuthController::class, 'login'])->name('users.login');
Route::get('/users', [AuthController::class, 'indexShow'])->name('users.index');

// News
Route::get('/check', [NewsController::class, 'check'])->name('news.check');
Route::get('/news', [NewsController::class, 'indexShow'])->name('news.index');
Route::get('/news-create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news-store', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
Route::post('/news/{id}/update', [NewsController::class, 'update'])->name('news.update');

// News Details View Page (for front-end viewing)
Route::get('/news-details/{id}', function ($id) {
    return view('news.details', ['newsId' => $id]);
})->name('news.details');

// Movies
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

// Shopping
Route::get('/shopping', [ShoppingController::class, 'index'])->name('shopping.index');
