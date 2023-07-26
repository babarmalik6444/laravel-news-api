<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\FiltersController;
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

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::post('/create', 'store');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
});

Route::controller(FiltersController::class)->group(function () {
    Route::get('/filters', 'getFilters');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
    });

    Route::controller(SearchController::class)->group(function () {
        Route::post('/search', 'index');
    });
});

Route::controller(SearchController::class)->group(function () {
    Route::post('/search', 'index');
});
