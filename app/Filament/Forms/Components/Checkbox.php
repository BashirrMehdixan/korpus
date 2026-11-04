<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Checkbox as BaseCheckbox;
use Filament\Forms\Components\Concerns\HasJsRenderer;
use Illuminate\Support\Facades\Vite;

class Checkbox extends BaseCheckbox
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/checkbox.ts');
    }
}

