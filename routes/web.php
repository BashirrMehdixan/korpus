<?php

use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\MenuController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::put('/{menu}', [MenuController::class, 'store'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
    });
});
