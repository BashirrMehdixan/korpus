<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        $availableLocales = ['az', 'en', 'ru'];

        if (in_array($locale, $availableLocales)) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale', 'az'));
        }

        url()->defaults(['locale' => $request->route('locale')]);

        return $next($request);
    }
}
