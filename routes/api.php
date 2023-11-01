<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Verify Email
Route::get('emial/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
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
