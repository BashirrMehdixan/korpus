<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Vite;

class DatePicker extends Field
{
    use HasJsRenderer;

    protected mixed $defaultValue = null;
    protected bool $isNative = true;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/date-picker.ts');
    }

    public function native(bool $condition = true): static
    {
        $this->isNative = $condition;
        return $this;
    }

    public function getRendererConfiguration(): array
    {
        return [];
    }
}
