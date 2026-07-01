<?php

namespace App\Filament\Resources\Groups\Pages;

use App\Filament\Resources\Groups\GroupResource;
use App\Services\PaymentGenerationService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected array $oldStudentIds = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->oldStudentIds = $this->record->students()->pluck('users.id')->toArray();

        return $data;
    }

    protected function afterSave(): void
    {
        $newStudentIds = $this->data['students'] ?? [];

        app(PaymentGenerationService::class)->regenerateForGroup(
            $this->record,
            $this->oldStudentIds,
            $newStudentIds
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
