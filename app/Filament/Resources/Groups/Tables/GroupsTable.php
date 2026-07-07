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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class GroupsTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('№')->rowIndex(),
                TextColumn::make('name')
                    ->label(__('main.name'))->searchable(),
                TextColumn::make('course.name')
                    ->label(__('main.course'))->searchable(),
                TextColumn::make('teacher.surname')->label(__('main.teacher'))
                    ->getStateUsing(fn(Group $record) => $record->teacher->surname . ' ' . $record->teacher->name),
                TextColumn::make('start_date')
                    ->label(__('main.start_and_end_date'))
                    ->getStateUsing(fn(Group $record) => $record->start_date->toFormattedDateString() . ' - ' . $record->end_date->toFormattedDateString()),
                TextColumn::make('payment_method')->label(__('main.payment_method'))
                    ->getStateUsing(fn(Group $record) => $record->payment_method === 1 ? 'Birdəfəlik' : 'Aylıq'),
                TextColumn::make('amount')->label(__('main.amount'))
                    ->getStateUsing(fn(Group $record) => $record->payment_method === 1 ? $record->fixed_amount : $record->monthly_amount)
                    ->money('AZN'),
                TextColumn::make('status')
                    ->label(__('main.status'))
                    ->getStateUsing(fn(Group $record) => $record->status ? __('main.active') : __('main.disable'))
                    ->badge()
                    ->color(fn(Group $record) => $record->status ? 'success' : 'danger'),
                TextColumn::make('created_at')->label(__('main.created_at'))->dateTime(),
                TextColumn::make('creator.name')->label(__('main.created_by'))->getStateUsing(fn(Group $record) => $record->creator->name . ' ' . $record->creator->surname),
            ])
            ->filters([
                TrashedFilter::make()->native(false),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
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
