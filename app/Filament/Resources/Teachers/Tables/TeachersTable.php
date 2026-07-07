<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TeachersTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

            ])
            ->filters([
                TrashedFilter::make()->native(false),
            ])
            ->recordActions([
            ])
            ->toolbarActions([
            ]);
    }
}
