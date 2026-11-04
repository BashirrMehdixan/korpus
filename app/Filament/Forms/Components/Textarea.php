<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Textarea as BaseTextarea;
use Illuminate\Support\Facades\Vite;

class Textarea extends BaseTextarea
{
    use HasJsRenderer;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/textarea.ts');
    }

    public function getRendererConfiguration(): array
    {
        return [
            'rows'        => $this->getRows(),
            'maxLength'   => $this->getMaxLength(),
            'placeholder' => $this->getPlaceholder(),
            'default'     => $this->getDefaultState(),
        ];
    }
}
