<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPanelLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('panel_locale', 'az');

        if (in_array($locale, ['az', 'en', 'ru'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
