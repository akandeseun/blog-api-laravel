<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

// Route::get('/fetch-url/post', [CommentController::class, 'getUrl']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    // Verify Email
    Route::post('/email/verification-notification', 'resendVerificationEmail')->middleware(['auth:sanctum'])->name('verification.send');

    // Resend Verification Mail
    Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->middleware(['auth:sanctum'])->name('verification.verify');
});




// Tag Routes
Route::controller(TagController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tag', 'index');
        Route::get('/tag/{id}', 'show');
        Route::post('/tag', 'store');
        Route::patch('/tag/{id}', 'update');
        Route::delete('/tag/{id}', 'destroy');
    });
});

// Category Routes
Route::controller(CategoryController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/category', 'index');
        Route::get('/category/{id}', 'show');
        Route::post('/category', 'store');
        Route::patch('/category/{id}', 'update');
        Route::delete('/category/{id}', 'destroy');
    });
});

// Posts Routes
Route::controller(PostController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/post', 'index');
        Route::get('/post/{id}', 'show');
        Route::post('/post', 'store');
        Route::patch('/post/{id}', 'update');
        Route::delete('/post/{id}', 'destroy');
    });
});


// Forgot Password Routes
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::get('/reset-password/{token}', 'passwordLink')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});


// Comment Routes
Route::controller(CommentController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/comment', 'index');
        Route::post('/comment', 'store');
        Route::get('/comment/{id}', 'show');
        Route::patch('/comment/{id}', 'update');
        Route::delete('/comment/{id}', 'destroy');
    });
});
