<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use \App\Http\Controllers\BrandsController;
use \App\Http\Controllers\CategoryController;
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


// Public routes for user registration and login
Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

// Public routes for brands
//brands routes
Route::get('brands', [BrandsController::class, 'index']); // Get all brands
Route::get('brands/{id}', [BrandsController::class, 'show']); // Get single brand by ID
//categories routes
Route::get('categories', [CategoryController::class, 'index']); // Get all categories
Route::get('category/{id}', [CategoryController::class, 'show']); // Get single category by ID

// Protected routes requiring JWT authentication
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [JWTAuthController::class, 'getUser']); // Get authenticated user details
    Route::post('logout', [JWTAuthController::class, 'logout']); // User logout
    //brands routes
    Route::post('store', [BrandsController::class, 'store']); // Create a new brand
    Route::put('brands/{id}', [BrandsController::class, 'update']); // Update a brand by ID
    Route::delete('brands/{id}', [BrandsController::class, 'destroy']); // Delete a brand by ID
    //categories routes
    Route::post('category store', [CategoryController::class, 'store']); // Create a new category
    Route::post('category/{id}', [CategoryController::class, 'update']); // Update a category by ID
    Route::delete('category/{id}', [CategoryController::class, 'destroy']); // Delete a category by ID
});

