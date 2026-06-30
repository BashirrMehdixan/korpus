<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'icon' => 'RiCommandLine',
            'route' => null,
            'parent_id' => null,
            'order' => 0,
            'has_dropdown' => false,
        ];
    }
}
