<?php

use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\MenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Dil prefiksi olan əsas qrup (Mütləq harada 'locale' olduğunu bildiririk)
Route::prefix('{locale}')
    ->where(['locale' => 'az|en|ru']) // Mühafizə: locale ancaq az, en, ru ola bilər!
    ->name('front.')
    ->group(function () {

        Route::get('/', [IndexController::class, 'index'])->name('index');

        Route::prefix('menus')->name('menus.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/', [MenuController::class, 'store'])->name('store');
            Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
            Route::put('/{menu}', [MenuController::class, 'store'])->name('update');
            Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
        });

    });

// 2. Storage marşrutu (Prefikslərdən tamamilə kənar)
Route::get('/storage/{path}', function ($path) {
    // fayl oxuma məntiqi
})->where('path', '.*')->name('storage.fetch');


// 3. DİL PREFİKSİ OLMADAN GƏLƏN BÜTÜN İSTƏKLƏRİN İDARƏEDİLMƏSİ (FALLBACK)
// Əgər istifadəçi /menus və ya birbaşa / yazarsa, bu fallback işə düşəcək
Route::fallback(function () {
    $segments = request()->segments();
    $defaultLocale = config('app.locale', 'az');

    // Əgər istifadəçi birbaşa ana domenə gəlibsə (http://korpus.test/) -> /az-a yönləndir
    if (empty($segments)) {
        return redirect()->to('/' . $defaultLocale);
    }

    // Əgər birinci segment dil deyilbə (məs: /menus), önünə default dili qoyub yönləndir -> /az/menus
    if (!in_array($segments[0], ['az', 'en', 'ru'])) {
        return redirect()->to('/' . $defaultLocale . '/' . implode('/', $segments));
    }

    abort(404);
});
