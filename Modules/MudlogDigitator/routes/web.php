<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CookiesMiddleware;

use Modules\MudlogDigitator\Http\Controllers\MudlogDigitatorController;

Route::prefix('mudlog-digitator')->group(function () {
    Route::controller(MudlogDigitatorController::class)->group(function () {
        Route::get('/', 'index')->name('mudlog-digitator.index');
    });
});

