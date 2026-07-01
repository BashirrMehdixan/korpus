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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('#')
                    ->rowIndex(),
                TextColumn::make('surname')
                    ->label(__('main.full_name'))
                    ->getStateUsing(fn(User $record) => "$record->surname $record->name $record->patronymic")
                    ->searchable(['surname', 'name', 'patronymic']),
                TextColumn::make('username')
                    ->label(__('main.username'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('main.phone'))
                    ->searchable(),
                TextColumn::make('email')->label(__('main.email'))->searchable(),
                TextColumn::make('roles.name')->label(__('main.role'))->searchable(),
                TextColumn::make('registration_date')->label(__('main.registration_date'))
                    ->sortable()->dateTime(),
                TextColumn::make('status')
                    ->label(__('main.status'))
                    ->getStateUsing(fn(User $record) => $record->status ? 'Aktiv' : 'Passiv')
                    ->badge()
                    ->color(fn(string $state) => $state === 'Aktiv' ? 'success' : 'danger')->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->native(false)
                    ->preload(),
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
