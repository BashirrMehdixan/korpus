<?php

namespace App\Filament\Resources\ActiveStudents\Pages;

use App\Filament\Resources\ActiveStudents\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
