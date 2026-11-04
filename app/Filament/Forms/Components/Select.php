<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\HasJsRenderer;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Vite;

class Select extends Field
{
    use HasJsRenderer;

    protected array|\Closure $selectOptions = [];
    protected bool $isMultiple = false;
    protected bool $isSearchable = false;
    protected bool $isPreloaded = false;
    protected ?string $relationshipName = null;
    protected ?string $titleAttribute = null;
    protected ?\Closure $modifyQueryUsing = null;
    protected ?\Closure $getOptionLabelFromRecordUsing = null;

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/forms/components/select.ts');
    }

    public function options(array|\Closure $options): static
    {
        $this->selectOptions = $options;
        return $this;
    }

    public function multiple(): static
    {
        $this->isMultiple = true;
        return $this;
    }

    public function searchable(): static
    {
        $this->isSearchable = true;
        return $this;
    }

    public function preload(): static
    {
        $this->isPreloaded = true;
        return $this;
    }

    public function relationship(string $name, string $titleAttribute, ?\Closure $modifyQueryUsing = null): static
    {
        $this->relationshipName = $name;
        $this->titleAttribute = $titleAttribute;
        $this->modifyQueryUsing = $modifyQueryUsing;
        return $this;
    }

    public function getOptionLabelFromRecordUsing(\Closure $callback): static
    {
        $this->getOptionLabelFromRecordUsing = $callback;
        return $this;
    }

    protected function resolveOptions(): array
    {
        if ($this->relationshipName) {
            $model = $this->getRecord();
            if (! $model) {
                $modelClass = $this->getModel();
                if ($modelClass && class_exists($modelClass)) {
                    $model = new $modelClass;
                }
            }

            if ($model && method_exists($model, $this->relationshipName)) {
                $query = $model->{$this->relationshipName}()->getRelated()->newQuery();
                if ($this->modifyQueryUsing) {
                    $query = ($this->modifyQueryUsing)($query);
                }
                $results = $query->get();
                $labelCallback = $this->getOptionLabelFromRecordUsing;
                return $results->mapWithKeys(function ($item) use ($labelCallback) {
                    $label = $labelCallback ? $labelCallback($item) : $item->{$this->titleAttribute};
                    return [(string) $item->getKey() => (string) $label];
                })->toArray();
            }
        }

        $opts = $this->selectOptions;
        if ($opts instanceof \Closure) {
            return $opts();
        }
        return $opts ?? [];
    }

    public function getRendererConfiguration(): array
    {
        return [
            'options'      => $this->resolveOptions(),
            'isMultiple'   => $this->isMultiple,
            'isSearchable' => $this->isSearchable,
        ];
    }
}
