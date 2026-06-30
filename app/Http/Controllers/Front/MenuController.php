<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function index(): Response
    {
        $menus = Menu::with('translations')->orderBy('order')->get()->map(function ($menu) {
            return [
                'id' => $menu->id,
                'icon' => $menu->icon,
                'route' => $menu->route,
                'order' => $menu->order,
                'status' => $menu->status,
                'translations' => $menu->translations->keyBy('locale')->map(fn($t) => ['title' => $t->title]),
            ];
        });

        return Inertia::render('menu/index', ['menus' => $menus]);
    }

    public function edit(Menu $menu): Response
    {
        $menu->load('translations');

        $menuData = [
            'id' => $menu->id,
            'parent_id' => $menu->parent_id, // Parent ID əlavə olundu
            'icon' => $menu->icon,
            'route' => $menu->route,
            'order' => $menu->order,
            'status' => $menu->status,
            'translations' => $menu->translations->keyBy('locale')->map(fn($t) => $t->title),
        ];

        // Redaktə zamanı menyunun özünü özünə parent seçməməsi üçün öz id-sini çıxarırıq
        $rootMenus = Menu::root()
            ->where('id', '!=', $menu->id)
            ->with('translations')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'title' => $m->translations->firstWhere('locale', app()->getLocale())?->title ?? 'Başlıqsız',
                ];
            });

        return Inertia::render('menu/create', [
            'menu' => $menuData,
            'rootMenus' => $rootMenus
        ]);
    }

    public function store(Request $request, ?Menu $menu = null): RedirectResponse
    {
        $data = $request->validate([
            'parent_id' => 'nullable|exists:menus,id', // Validasiya əlavə olundu
            'icon' => 'nullable|string|max:100',
            'route' => 'nullable|string|max:100',
            'order' => 'integer|min:0',
            'status' => 'boolean',
            'translations' => 'required|array',
            'translations.az' => 'required|string|max:255',
            'translations.en' => 'required|string|max:255',
            'translations.ru' => 'required|string|max:255',
        ]);

        $payload = [
            'parent_id' => $data['parent_id'] ?? null,
            'icon' => $data['icon'] ?? null,
            'route' => $data['route'] ?? null,
            'order' => $data['order'] ?? 0,
            'status' => $data['status'] ?? false,
        ];

        if ($menu) {
            $menu->update($payload);
        } else {
            $menu = Menu::create($payload);
        }

        foreach ($data['translations'] as $locale => $title) {
            MenuTranslation::updateOrCreate(
                ['menu_id' => $menu->id, 'locale' => $locale],
                ['title' => $title],
            );
        }

        return redirect()->route($this->localRoute('menus.index'));
    }

    public function create(): Response
    {
        // Ana menyuları (parent_id null olanları) tapırıq
        $rootMenus = Menu::root()->with('translations')->get()->map(function ($menu) {
            return [
                'id' => $menu->id,
                'title' => $menu->translations->firstWhere('locale', app()->getLocale())?->title ?? 'Başlıqsız',
            ];
        });

        return Inertia::render('menu/create', [
            'rootMenus' => $rootMenus
        ]);
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();
        return redirect()->route($this->localRoute('menus.index'));
    }

    protected function localRoute(string $name): string
    {
        $prefix = app()->getLocale() === 'az' ? 'front' : app()->getLocale();
        return "{$prefix}.{$name}";
    }
}
