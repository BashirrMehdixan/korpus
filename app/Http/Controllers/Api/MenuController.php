<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        $locale = request('locale', app()->getLocale());

        $menus = Menu::root()->get()->map(function (Menu $menu) use ($locale) {
            return $this->formatMenu($menu, $locale);
        });

        return response()->json($menus);
    }

    private function formatMenu(Menu $menu, string $locale): array
    {
        return [
            'id' => $menu->id,
            'icon' => $menu->icon,
            'route' => $menu->route,
            'title' => $menu->translation($locale)?->title ?? $menu->translation('az')?->title ?? '',
            'status' => $menu->status,
            'children' => $menu->children->map(fn($child) => $this->formatMenu($child, $locale)),
        ];
    }
}
