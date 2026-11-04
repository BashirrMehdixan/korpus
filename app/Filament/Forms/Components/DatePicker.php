<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\DatePicker as BaseDatePicker;
use Illuminate\Support\Facades\Vite;

class DatePicker extends BaseDatePicker
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/date-picker.ts');
    }

    public function getRendererConfiguration(): array
    {
        $default = $this->getDefaultState();
        if ($default instanceof \DateTimeInterface) {
            $default = $default->format('Y-m-d');
        }

        return [
            'minDate'     => $this->getMinDate(),
            'maxDate'     => $this->getMaxDate(),
            'placeholder' => $this->getPlaceholder(),
            'default'     => $default,
        ];
    }
}
