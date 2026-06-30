<?php

use App\Http\Controllers\Front\IndexController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
});
