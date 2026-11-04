<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\DateTimePicker as BaseDateTimePicker;
use Illuminate\Support\Facades\Vite;

class DateTimePicker extends BaseDateTimePicker
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/date-time-picker.ts');
    }

    public function getRendererConfiguration(): array
    {
        $default = $this->getDefaultState();
        if ($default instanceof \DateTimeInterface) {
            $default = $default->format('Y-m-d H:i:s');
        }

        return [
            'minDate'     => $this->getMinDate(),
            'maxDate'     => $this->getMaxDate(),
            'placeholder' => $this->getPlaceholder(),
            'default'     => $default,
        ];
    }
}
