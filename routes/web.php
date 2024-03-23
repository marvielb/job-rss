<?php

use App\Http\Controllers\JobListingsController;
use Illuminate\Support\Facades\Route;

Route::controller(JobListingsController::class)->group(function () {
    Route::get('/', 'index');
});
