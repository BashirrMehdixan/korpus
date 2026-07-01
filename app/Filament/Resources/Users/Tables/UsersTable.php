<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('Sıra nömrəsi')->rowIndex(),
                TextColumn::make('surname')->label('S.A.A')
                    ->getStateUsing(fn(User $record) => "$record->surname $record->name $record->patronymic"),
                TextColumn::make('phone')->label('Əlaqə nömrəsi'),
                TextColumn::make('email')->label('E-poçt'),
                TextColumn::make('registration_date')->label('Qeydiyyat tarixi'),
                TextColumn::make('status')->label('Aktivlik')
                    ->getStateUsing(fn(User $record) => $record->status ? 'Aktiv' : 'Passiv')
                    ->badge(fn(User $record) => $record->status ? 'success' : 'danger'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
