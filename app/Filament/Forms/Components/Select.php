<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Select as BaseSelect;
use Illuminate\Support\Facades\Vite;

class Select extends BaseSelect
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/select.ts');
    }

    public function getRendererConfiguration(): array
    {
        $options = $this->getOptionsForJs();

        if (empty($options)) {
            $options = $this->getOptions();
        }

        return [
            'options'      => $options,
            'isMultiple'   => $this->isMultiple(),
            'isSearchable' => $this->isSearchable(),
            'placeholder'  => $this->getPlaceholder(),
            'default'      => $this->getDefaultState(),
        ];
    }
}
