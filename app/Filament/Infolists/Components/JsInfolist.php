<?php

namespace App\Filament\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Concerns\HasJsRenderer;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Vite;

class JsInfolist extends Component
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

        return array_merge([
            'columns' => $this->getColumns(),
            'columnSpan' => $this->getColumnSpan(),
            'schema' => $serializedSchema,
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
            $component instanceof Group ||
            $component instanceof \Filament\Infolists\Components\Section
        ) {
            $data['type'] = 'section';

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

        // Entries: TextEntry, etc.
        if ($component instanceof Entry) {
            $data['type'] = 'entry';
            $data['name'] = $component->getName();

            try {
                $data['label'] = (string) $component->getLabel();
            } catch (\Throwable) {
                $data['label'] = $component->getName();
            }

            // State value evaluation
            $state = null;
            try {
                $state = $component->getState();
                if ($state instanceof \DateTimeInterface) {
                    $state = $state->format('d/m/Y H:i');
                } elseif (is_iterable($state)) {
                    $state = collect($state)->map(fn($item) => is_object($item) ? ($item->name ?? (string) $item) : (string) $item)->values()->toArray();
                }
            } catch (\Throwable) {
                $state = null;
            }
            $data['state'] = $state;

            // Badge check
            try {
                $data['isBadge'] = (bool) $component->isBadge($state);
            } catch (\Throwable) {
                $data['isBadge'] = false;
            }

            // Color
            try {
                $data['color'] = $component->getColor($state);
            } catch (\Throwable) {
                $data['color'] = null;
            }

            // Icon
            try {
                $data['icon'] = $component->getIcon($state);
            } catch (\Throwable) {
                $data['icon'] = null;
            }

            // Copyable
            try {
                $data['isCopyable'] = (bool) $component->isCopyable($state);
            } catch (\Throwable) {
                $data['isCopyable'] = false;
            }

            return $data;
        }

        return null;
    }

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/infolists/components/js-infolist.ts');
    }
}

