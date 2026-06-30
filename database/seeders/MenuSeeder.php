<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuTranslation;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'icon' => 'RiLayoutGridFill',
                'route' => 'front.index',
                'order' => 0,
                'translations' => [
                    'az' => 'Mənim Panelim',
                    'en' => 'Dashboard',
                    'ru' => 'Панель управления',
                ],
            ],
            [
                'icon' => 'RiTeamLine',
                'route' => null,
                'order' => 1,
                'translations' => [
                    'az' => 'Tələbələr',
                    'en' => 'Students',
                    'ru' => 'Студенты',
                ],
            ],
            [
                'icon' => 'RiUserLine',
                'route' => null,
                'order' => 2,
                'translations' => [
                    'az' => 'Müəllimlər',
                    'en' => 'Teachers',
                    'ru' => 'Учителя',
                ],
            ],
            [
                'icon' => 'RiBookOpenLine',
                'route' => null,
                'order' => 3,
                'translations' => [
                    'az' => 'Tədris',
                    'en' => 'Education',
                    'ru' => 'Образование',
                ],
            ],
            [
                'icon' => 'RiMoneyDollarCircleLine',
                'route' => null,
                'order' => 4,
                'translations' => [
                    'az' => 'Maliyyə',
                    'en' => 'Finance',
                    'ru' => 'Финансы',
                ],
            ],
        ];

        foreach ($menus as $data) {
            $translations = $data['translations'];
            unset($data['translations']);

            $menu = Menu::create($data);

            foreach ($translations as $locale => $title) {
                MenuTranslation::create([
                    'menu_id' => $menu->id,
                    'locale' => $locale,
                    'title' => $title,
                ]);
            }
        }
    }
}
