<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    public function getTabs(): array
    {
        return [
            'aktiv' => Tab::make('Aktiv')
                ->modifyQueryUsing(fn(Builder $q) => $q->where('status', true))
                ->icon('heroicon-o-check-circle'),
            'passiv' => Tab::make('Passiv')
                ->modifyQueryUsing(fn(Builder $q) => $q->where('status', false))
                ->icon('heroicon-o-x-circle'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
