<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\TextInput as BaseTextInput;
use Illuminate\Support\Facades\Vite;

class TextInput extends BaseTextInput
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/text-input.ts');
    }

    public function getRendererConfiguration(): array
    {
        return [
            'type'        => $this->getType(),
            'prefix'      => $this->getPrefixLabel(),
            'suffix'      => $this->getSuffixLabel(),
            'maxLength'   => $this->getMaxLength(),
            'minValue'    => $this->getMinValue(),
            'step'        => $this->getStep(),
            'placeholder' => $this->getPlaceholder(),
            'default'     => $this->getDefaultState(),
        ];
    }
}
