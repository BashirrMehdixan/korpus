<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Vite;

class TextInput extends Field
{
    use HasJsRenderer;

    protected string $inputType = 'text';
    protected ?string $prefix = null;
    protected ?string $suffix = null;
    protected ?int $maxLength = null;
    protected mixed $minValue = null;
    protected ?string $step = null;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/text-input.ts');
    }

    public function numeric(): static
    {
        $this->inputType = 'number';
        $this->step = 'any';
        return $this;
    }

    public function integer(): static
    {
        $this->inputType = 'number';
        $this->step = '1';
        return $this;
    }

    public function password(): static
    {
        $this->inputType = 'password';
        return $this;
    }

    public function email(): static
    {
        $this->inputType = 'email';
        return $this;
    }

    public function tel(): static
    {
        $this->inputType = 'tel';
        return $this;
    }

    public function url(): static
    {
        $this->inputType = 'url';
        return $this;
    }

    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function suffix(string $suffix): static
    {
        $this->suffix = $suffix;
        return $this;
    }

    public function maxLength(int $length): static
    {
        $this->maxLength = $length;
        return $this;
    }

    public function minValue(mixed $value): static
    {
        $this->minValue = $value;
        return $this;
    }

    public function getRendererConfiguration(): array
    {
        return [
            'type'      => $this->inputType,
            'prefix'    => $this->prefix,
            'suffix'    => $this->suffix,
            'maxLength' => $this->maxLength,
            'minValue'  => $this->minValue,
            'step'      => $this->step,
        ];
    }
}
