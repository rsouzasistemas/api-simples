<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('index');
    Route::post('/users', [UserController::class, 'store'])->name('store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy');

    Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');