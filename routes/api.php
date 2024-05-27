<?php

use App\Http\Controllers\CheckHealthController;
use Illuminate\Support\Facades\Route;

Route::controller(CheckHealthController::class)
    ->prefix('check-health')
    ->group(function () {
        Route::get('/', 'index');
    });
