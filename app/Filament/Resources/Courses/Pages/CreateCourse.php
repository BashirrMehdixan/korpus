<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = [];
        $data['description'] = [];

        foreach (['az', 'en', 'ru'] as $locale) {
            if ($name = $data["name_{$locale}"] ?? null) {
                $data['name'][$locale] = $name;
            }
            if (isset($data["description_{$locale}"])) {
                $data['description'][$locale] = $data["description_{$locale}"];
            }
            unset($data["name_{$locale}"], $data["description_{$locale}"]);
        }

        return $data;
    }
}
