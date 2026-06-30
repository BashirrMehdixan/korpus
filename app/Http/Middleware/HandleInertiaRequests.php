<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        // N+1 probleminin qarşısını almaq üçün translations ilə birlikdə çəkirik
        $menus = Menu::root()
            ->where('status', true)
            ->with(['translations', 'children.translations'])
            ->get()
            ->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'icon' => $menu->icon,
                    'route' => $menu->route,
                    'order' => $menu->order,
                    'status' => $menu->status,
                    // Front-end-də menu.translations.az.title formatında rahat oxunması üçün key-by locale edirik
                    'translations' => $menu->translations->keyBy('locale')->map(function ($trans) {
                        return ['title' => $trans->title];
                    })->toArray(),
                    // Əgər alt menyular (children) istifadə edəcəksənsə:
                    'children' => $menu->children->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'icon' => $child->icon,
                            'route' => $child->route,
                            'order' => $child->order,
                            'status' => $child->status,
                            'translations' => $child->translations->keyBy('locale')->map(function ($trans) {
                                return ['title' => $trans->title];
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            });

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'menus' => $menus,
            'auth' => [
                'user' => $request->user(),
            ],
        ];
    }
}
