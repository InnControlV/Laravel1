<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\ContentControllerController;
use App\Http\Controllers\BookmarkController;

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
Route::get('/news-list', [NewsController::class, 'index']);


Route::get('/test-db', function () {
    try {
        DB::connection()->getMongoClient(); // MongoDB client
        return 'Connected to MongoDB successfully';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

Route::post('signupOrLogin', [AuthController::class, 'signupOrLogin'])->name('login');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

Route::get('/read', [ContentControllerController::class, 'read']);



Route::post('/news-store', [NewsController::class, 'store']);


Route::get('/bookmark', [BookmarkController::class, 'create']);
// Route::delete('/bookmark', [BookmarkController::class, 'delete']);
// Route::get('/bookmarks', [BookmarkController::class, 'index']);


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


});
