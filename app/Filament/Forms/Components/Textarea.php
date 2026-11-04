<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Vite;

class Textarea extends Field
{
    use HasJsRenderer;

    protected int $rows = 3;
    protected ?int $maxLength = null;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/textarea.ts');
    }

    public function rows(int $rows): static
    {
        $this->rows = $rows;
        return $this;
    }

    public function maxLength(int $length): static
    {
        $this->maxLength = $length;
        return $this;
    }

    public function getRendererConfiguration(): array
    {
        return [
            'rows'      => $this->rows,
            'maxLength' => $this->maxLength,
        ];
    }
}
