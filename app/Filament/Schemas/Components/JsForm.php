<?php

namespace App\Filament\Schemas\Components;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Concerns\HasJsRenderer;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Vite;

class JsForm extends Component
{
    use HasJsRenderer;

    protected array $configuration = [];

    final public function __construct(array | Closure $schema = [])
    {
        $this->schema($schema);
    }

    public static function make(array | Closure $schema = []): static
    {
        $static = app(static::class, ['schema' => $schema]);
        $static->configure();

        return $static;
    }

    public function configuration(array $configuration): static
    {
        $this->configuration = array_merge($this->configuration, $configuration);

        return $this;
    }

    public function getRendererConfiguration(): array
    {
        $serializedSchema = [];
        $rawChildren = $this->getDefaultChildComponents();

        if (is_array($rawChildren)) {
            foreach ($rawChildren as $child) {
                if ($serialized = $this->serializeComponent($child)) {
                    $serializedSchema[] = $serialized;
                }
            }
        }

        $rolesFallback = [];
        try {
            $user = auth()->user();
            $rolesQuery = \Spatie\Permission\Models\Role::query();
            if (! ($user && method_exists($user, 'hasRole') && $user->hasRole('super_admin'))) {
                $rolesQuery->where('name', '!=', 'super_admin');
            }
            foreach ($rolesQuery->get() as $r) {
                $rolesFallback[] = [
                    'value' => $r->id,
                    'label' => $r->name,
                ];
            }
        } catch (\Throwable) {}

        return array_merge([
            'columns' => $this->getColumns(),
            'columnSpan' => $this->getColumnSpan(),
            'schema' => $serializedSchema,
            'roles' => $rolesFallback,
        ], $this->configuration);
    }

    protected function serializeComponent(mixed $component): ?array
    {
        if (! ($component instanceof Component)) {
            return null;
        }

        // Check visibility
        try {
            if ($component->isHidden()) {
                return null;
            }
        } catch (\Throwable) {}

        try {
            if (! $component->isVisible()) {
                return null;
            }
        } catch (\Throwable) {}

        $data = [];

        try {
            $data['id'] = $component->getId();
        } catch (\Throwable) {
            $data['id'] = null;
        }

        try {
            $data['columns'] = $component->getColumns();
        } catch (\Throwable) {
            $data['columns'] = null;
        }

        try {
            $data['columnSpan'] = $component->getColumnSpan();
        } catch (\Throwable) {
            $data['columnSpan'] = null;
        }

        // Containers: Section, Fieldset, Grid, Group
        if (
            $component instanceof Section ||
            $component instanceof Fieldset ||
            $component instanceof Grid ||
            $component instanceof Group
        ) {
            $data['type'] = match (true) {
                $component instanceof Section => 'section',
                $component instanceof Fieldset => 'fieldset',
                $component instanceof Grid => 'grid',
                default => 'group',
            };

            try {
                $data['heading'] = $component->getHeading() ? (string) $component->getHeading() : null;
            } catch (\Throwable) {
                $data['heading'] = null;
            }

            try {
                $data['description'] = $component->getDescription() ? (string) $component->getDescription() : null;
            } catch (\Throwable) {
                $data['description'] = null;
            }

            try {
                $data['collapsible'] = (bool) $component->isCollapsible();
            } catch (\Throwable) {
                $data['collapsible'] = false;
            }

            try {
                $data['collapsed'] = (bool) $component->isCollapsed();
            } catch (\Throwable) {
                $data['collapsed'] = false;
            }

            $children = [];
            if (method_exists($component, 'getDefaultChildComponents')) {
                try {
                    $rawChildComponents = $component->getDefaultChildComponents();
                    if (is_array($rawChildComponents)) {
                        foreach ($rawChildComponents as $child) {
                            if ($serialized = $this->serializeComponent($child)) {
                                $children[] = $serialized;
                            }
                        }
                    }
                } catch (\Throwable) {}
            }

            $data['schema'] = $children;

            return $data;
        }

        // Field components
        if ($component instanceof Field) {
            $data['type'] = 'field';
            $data['name'] = $component->getName();
            try {
                $data['statePath'] = $component->getStatePath();
            } catch (\Throwable) {
                $data['statePath'] = $component->getName();
            }

            try {
                $data['label'] = (string) $component->getLabel();
            } catch (\Throwable) {
                $data['label'] = $component->getName();
            }

            try {
                $data['required'] = (bool) $component->isRequired();
            } catch (\Throwable) {
                $data['required'] = false;
            }

            try {
                $data['disabled'] = (bool) $component->isDisabled();
            } catch (\Throwable) {
                $data['disabled'] = false;
            }

            try {
                $data['readOnly'] = (bool) $component->isReadOnly();
            } catch (\Throwable) {
                $data['readOnly'] = false;
            }

            try {
                $data['placeholder'] = $component->getPlaceholder();
            } catch (\Throwable) {
                $data['placeholder'] = null;
            }

            try {
                $data['helperText'] = $component->getHelperText() ? (string) $component->getHelperText() : null;
            } catch (\Throwable) {
                $data['helperText'] = null;
            }

            try {
                $data['hint'] = $component->getHint() ? (string) $component->getHint() : null;
            } catch (\Throwable) {
                $data['hint'] = null;
            }

            // Default value
            try {
                $defaultState = method_exists($component, 'getDefaultState') ? $component->getDefaultState() : null;
                if ($defaultState instanceof \DateTimeInterface) {
                    $defaultState = $defaultState->format('Y-m-d H:i');
                }
                $data['default'] = $defaultState;
            } catch (\Throwable) {
                $data['default'] = null;
            }

            // Detect field type & attributes
            $className = get_class($component);

            if (str_contains($className, 'TextInput')) {
                $data['fieldType'] = 'text';
                $inputType = 'text';
                if (method_exists($component, 'isPassword') && $component->isPassword()) {
                    $inputType = 'password';
                } elseif (method_exists($component, 'isEmail') && $component->isEmail()) {
                    $inputType = 'email';
                } elseif (method_exists($component, 'isTel') && $component->isTel()) {
                    $inputType = 'tel';
                } elseif (method_exists($component, 'isNumeric') && $component->isNumeric()) {
                    $inputType = 'number';
                } elseif (method_exists($component, 'getType')) {
                    $inputType = $component->getType() ?: 'text';
                }
                $data['inputType'] = $inputType;
                $data['maxLength'] = method_exists($component, 'getMaxLength') ? $component->getMaxLength() : null;
                $data['prefix'] = method_exists($component, 'getPrefixLabel') ? $component->getPrefixLabel() : null;
                $data['suffix'] = method_exists($component, 'getSuffixLabel') ? $component->getSuffixLabel() : null;
            } elseif (str_contains($className, 'Select')) {
                $data['fieldType'] = 'select';
                $data['multiple'] = method_exists($component, 'isMultiple') ? (bool) $component->isMultiple() : false;
                $data['searchable'] = method_exists($component, 'isSearchable') ? (bool) $component->isSearchable() : false;

                $options = [];

                if (method_exists($component, 'getOptionsForJs')) {
                    try {
                        $options = $component->getOptionsForJs();
                    } catch (\Throwable) {}
                }

                if (empty($options)) {
                    try {
                        $rawOptions = $component->getOptions();
                        if (is_array($rawOptions)) {
                            foreach ($rawOptions as $val => $lbl) {
                                $options[] = ['value' => $val, 'label' => (string) $lbl];
                            }
                        }
                    } catch (\Throwable) {}
                }

                // If still empty and component has a relationship
                if (empty($options) && method_exists($component, 'hasRelationship') && $component->hasRelationship()) {
                    try {
                        $relationship = $component->getRelationship();
                        $titleColumn = $component->getRelationshipTitleAttribute();
                        $keyColumn = $relationship->getRelated()->getKeyName();

                        $query = $relationship->getRelated()->newQuery();
                        if ($component->getName() === 'roles') {
                            $user = auth()->user();
                            if (! ($user && method_exists($user, 'hasRole') && $user->hasRole('super_admin'))) {
                                $query->where('name', '!=', 'super_admin');
                            }
                        }

                        $records = $query->limit(100)->get();
                        foreach ($records as $record) {
                            $options[] = [
                                'value' => $record->{$keyColumn},
                                'label' => (string) ($record->{$titleColumn} ?? $record->{$keyColumn}),
                            ];
                        }
                    } catch (\Throwable) {}
                }

                // Direct fallback for roles
                if (empty($options) && $component->getName() === 'roles') {
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

                $data['options'] = $options;
            } elseif (str_contains($className, 'ToggleButtons')) {
                $data['fieldType'] = 'toggle-buttons';
                $data['inline'] = method_exists($component, 'isInline') ? (bool) $component->isInline() : true;

                $options = [];
                try {
                    $rawOptions = $component->getOptions();
                    foreach ($rawOptions as $val => $lbl) {
                        $options[] = ['value' => $val, 'label' => (string) $lbl];
                    }
                } catch (\Throwable) {
                    $options = [
                        ['value' => 1, 'label' => 'Aktiv'],
                        ['value' => 0, 'label' => 'Deaktiv'],
                    ];
                }
                $data['options'] = $options;
            } elseif (str_contains($className, 'Textarea')) {
                $data['fieldType'] = 'textarea';
                $data['rows'] = method_exists($component, 'getRows') ? $component->getRows() : 4;
                $data['maxLength'] = method_exists($component, 'getMaxLength') ? $component->getMaxLength() : null;
            } elseif (str_contains($className, 'DateTimePicker')) {
                $data['fieldType'] = 'date-time-picker';
            } elseif (str_contains($className, 'DatePicker')) {
                $data['fieldType'] = 'date-picker';
            } else {
                $data['fieldType'] = 'text';
                $data['inputType'] = 'text';
            }

            return $data;
        }

        return null;
    }

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/schemas/components/js-form.ts');
    }
}
