<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Vite;

class DateTimePicker extends Field
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/date-time-picker.ts');
    }

    public function getRendererConfiguration(): array
    {
        return [];
    }
}
