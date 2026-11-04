<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Concerns\HasJsRenderer;
use Illuminate\Support\Facades\Vite;
use Spatie\Permission\Models\Role;

class JsForm extends Component
{
    use HasJsRenderer;

    protected array $configuration = [];

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }

    public function configuration(array $configuration): static
    {
        $this->configuration = $configuration;
        return $this;
    }

    public function getRendererConfiguration(): array
    {
        $user = auth()->user();
        $rolesQuery = Role::query();
        if (! ($user && $user->hasRole('super_admin'))) {
            $rolesQuery->where('name', '!=', 'super_admin');
        }

        return array_merge([
            'roles' => $rolesQuery->get()->map(fn($r) => ['value' => $r->id, 'label' => $r->name])->toArray(),
        ], $this->configuration);
    }

    public function getRenderer(): string
    {
        return Vite::asset('resources/js/filament/schemas/components/js-form.ts');
    }
}
