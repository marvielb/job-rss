<?php

use App\Http\Controllers\CheckHealthController;
use App\Http\Controllers\OnlineJobPhJobsController;
use Illuminate\Support\Facades\Route;

Route::controller(CheckHealthController::class)
    ->prefix('check-health')
    ->group(function () {
        Route::get('/', 'index');
    });

Route::controller(OnlineJobPhJobsController::class)
    ->prefix('/online-job-ph/jobs')
    ->group(function () {
        Route::get('/', 'index');
    });
