<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Bütün Tələbələr'),
            'active' => Tab::make('Aktiv Tələbələr')
                ->modifyQueryUsing(fn($query) => $query->where('status', true)),
            'archived' => Tab::make('Çıxmış Tələbələr')
                ->modifyQueryUsing(fn($query) => $query->where('status', false)), // və ya SoftDeletes ilə ->onlyTrashed()
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
