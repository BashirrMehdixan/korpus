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
        $options = [];

        try {
            $options = $this->getOptionsForJs();
        } catch (\Throwable) {}

        if (empty($options)) {
            try {
                $rawOptions = $this->getOptions();
                if (! empty($rawOptions)) {
                    $options = $this->transformOptionsForJs($rawOptions);
                }
            } catch (\Throwable) {}
        }

        // Load options from relationship if available
        if (empty($options) && $this->hasRelationship()) {
            try {
                $relationship = $this->getRelationship();
                $titleColumn = $this->getRelationshipTitleAttribute();
                $keyColumn = $relationship->getRelated()->getKeyName();

                $query = $relationship->getRelated()->newQuery();

                if ($this->getName() === 'roles') {
                    $user = auth()->user();
                    if (! ($user && method_exists($user, 'hasRole') && $user->hasRole('super_admin'))) {
                        $query->where('name', '!=', 'super_admin');
                    }
                }

                $records = $query->limit(100)->get();
                $mapped = [];
                foreach ($records as $record) {
                    $mapped[] = [
                        'value' => $record->{$keyColumn},
                        'label' => (string) ($record->{$titleColumn} ?? $record->{$keyColumn}),
                    ];
                }
                $options = $mapped;
            } catch (\Throwable) {}
        }

        // Direct fallback for roles
        if (empty($options) && $this->getName() === 'roles') {
            try {
                $rolesQuery = \Spatie\Permission\Models\Role::query();
                $user = auth()->user();
                if (! ($user && method_exists($user, 'hasRole') && $user->hasRole('super_admin'))) {
                    $rolesQuery->where('name', '!=', 'super_admin');
                }
                foreach ($rolesQuery->get() as $r) {
                    $options[] = [
                        'value' => $r->id,
                        'label' => $r->name,
                    ];
                }
            } catch (\Throwable) {}
        }

        // Option labels for selected records
        try {
            $labels = $this->getOptionLabels();
            if (! empty($labels)) {
                $existingValues = array_column($options, 'value');
                foreach ($labels as $k => $v) {
                    if (! in_array($k, $existingValues)) {
                        $options[] = [
                            'value' => $k,
                            'label' => (string) $v,
                        ];
                    }
                }
            }
        } catch (\Throwable) {}

        return [
            'options'      => $options,
            'isMultiple'   => $this->isMultiple(),
            'isSearchable' => $this->isSearchable(),
            'placeholder'  => $this->getPlaceholder(),
            'default'      => $this->getDefaultState(),
        ];
    }
}
