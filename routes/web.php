<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Reviews\ReviewsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn()=> Inertia('Auth/Login') )->name('login');
    Route::post('/login', LoginController::class)->middleware('throttle:login')->name('login.store');
    Route::get('/register',[RegistrationController::class,'show'] )->name('register.show');
    Route::post('/register',[RegistrationController::class,'store'] )->middleware('throttle:register')->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn()=> Inertia('Dashboard/Index') )->name('home');
    Route::resource('/dashboard',DashboardController::class);
    Route::post('/logout', LogoutController::class)->name('logout');
    Route::get('/reviews/settings',[ReviewsController::class,'settings'])->name('reviews.settings');
    Route::post('/reviews',[ReviewsController::class,'store'])->name('reviews.store');
});
