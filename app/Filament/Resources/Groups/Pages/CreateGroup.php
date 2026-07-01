<?php

namespace App\Filament\Resources\Groups\Pages;

use App\Filament\Resources\Groups\GroupResource;
use App\Models\Group;
use App\Services\PaymentGenerationService;
use Filament\Resources\Pages\CreateRecord;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;

    protected function afterCreate(): void
    {
        $students = $this->data['students'] ?? [];

        if (!empty($students)) {
            app(PaymentGenerationService::class)->generateForGroup(
                $this->record,
                $students
            );
        }
    }
}
