<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\ToggleButtons as BaseToggleButtons;
use Illuminate\Support\Facades\Vite;

class ToggleButtons extends BaseToggleButtons
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/toggle-buttons.ts');
    }

    public function getRendererConfiguration(): array
    {
        return [
            'options'    => $this->getOptions(),
            'isInline'   => $this->isInline(),
            'isGrouped'  => $this->isGrouped(),
            'isMultiple' => $this->isMultiple(),
            'default'    => $this->getDefaultState(),
        ];
    }
}
