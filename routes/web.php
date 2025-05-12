<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CookiesMiddleware;

Route::middleware([AuthMiddleware::class])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/rtm/dashboard', 'index')->name('rtm.index');
        Route::get('/rtm/select', 'select')->name('rtm.select');
    });
});

Route::middleware([CookiesMiddleware::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::get('/request', 'register')->name('register');
    });
});

Route::get('/', function () { return view('welcome'); });