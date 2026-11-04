<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Vite;

class ToggleButtons extends Field
{
    use HasJsRenderer;

    protected array|\Closure $buttonOptions = [];
    protected bool $isInline = false;
    protected bool $isGrouped = false;
    protected bool $isBoolean = false;
    protected bool $isMultiple = false;
    protected bool $nullable = false;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/toggle-buttons.ts');
    }

    public function options(array|\Closure $options): static
    {
        $this->buttonOptions = $options;
        return $this;
    }

    public function boolean(): static
    {
        $this->isBoolean = true;
        return $this;
    }

    public function inline(bool $condition = true): static
    {
        $this->isInline = $condition;
        return $this;
    }

    public function grouped(bool $condition = true): static
    {
        $this->isGrouped = $condition;
        return $this;
    }

    public function multiple(): static
    {
        $this->isMultiple = true;
        return $this;
    }

    public function nullable(\Closure|bool $condition = true): static
    {
        $this->nullable = $condition instanceof \Closure ? $condition() : $condition;
        return $this;
    }

    public function getRendererConfiguration(): array
    {
        $opts = $this->buttonOptions instanceof \Closure
            ? ($this->buttonOptions)()
            : $this->buttonOptions;

        return [
            'options'    => $opts,
            'isInline'   => $this->isInline,
            'isGrouped'  => $this->isGrouped,
            'isBoolean'  => $this->isBoolean,
            'isMultiple' => $this->isMultiple,
        ];
    }
}
