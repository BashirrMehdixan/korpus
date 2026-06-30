<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureDefaults();

        Inertia::share([
            'locale' => fn () => app()->getLocale(),
            'translations' => fn () => $this->loadTranslations(app()->getLocale()),
            'availableLocales' => ['az', 'en', 'ru'],
        ]);
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    protected function loadTranslations(string $locale): array
    {
        $path = lang_path("{$locale}.json");
        if (File::exists($path)) {
            return json_decode(File::get($path), true) ?? [];
        }
        return [];
    }
}
