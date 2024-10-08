<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;

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

//books
Route::apiResource('/books', App\Http\Controllers\Api\BookController::class);
Route::apiResource('/categories', App\Http\Controllers\Api\CategoryController::class);
Route::apiResource('/register', App\Http\Controllers\Api\RegisterController::class);
Route::post('/login', [LoginController::class,'postlogin']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
