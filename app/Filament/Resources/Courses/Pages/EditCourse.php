<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        foreach (['az', 'en', 'ru'] as $locale) {
            $data["name_{$locale}"] = $record->getTranslation('name', $locale, false);
            $data["description_{$locale}"] = $record->getTranslation('description', $locale, false);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
