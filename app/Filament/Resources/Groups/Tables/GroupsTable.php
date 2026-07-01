<?php

namespace App\Filament\Resources\Groups\Tables;

use App\Models\Group;
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

class GroupsTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('№')->rowIndex(),
                TextColumn::make('name')->label('Ad')->searchable(),
                TextColumn::make('slug')->label('Slug')->searchable(),
                TextColumn::make('course.name')->label('Kurs')->searchable(),
                TextColumn::make('teacher.surname')->label('Müəllim')
                    ->getStateUsing(fn(Group $record) => "$record->teacher->surname $record->teacher->name"),
                TextColumn::make('start_date')->label('Başlama tarixi')->date(),
                TextColumn::make('end_date')->label('Bitmə tarixi')->date(),
                TextColumn::make('payment_method')->label('Ödəniş üsulu')
                    ->getStateUsing(fn(Group $record) => $record->payment_method === 1 ? 'Birdəfəlik' : 'Aylıq'),
                TextColumn::make('status')
                    ->label('Aktivlik')
                    ->getStateUsing(fn(Group $record) => $record->status ? 'Aktiv' : 'Passiv')
                    ->badge()
                    ->color(fn(string $state) => $state === 'Aktiv' ? 'success' : 'danger'),
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
