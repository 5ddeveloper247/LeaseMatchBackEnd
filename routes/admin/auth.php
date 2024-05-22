<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackEnd\Auth\RegisterController;
use App\Http\Controllers\BackEnd\Auth\LoginController;
use App\Http\Controllers\BackEnd\Dashboard\DashboarController;

//redirect if authenticated
Route::middleware(['admin.redirect'])->group(function () {
    Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login.view');
    Route::post('/admin/login', [LoginController::class, 'handleLogin'])->name('admin.login.submit');
});



//check role admin before access
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/dashboard', [DashboarController::class, 'Dashboard'])->name('admin.dashboard');
    // Add other admin routes here 
});
