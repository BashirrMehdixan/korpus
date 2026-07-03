<?php

namespace App\Filament\Resources\Courses\Tables;

use App\Models\Course;
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

class CoursesTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('№')->rowIndex(),
                TextColumn::make('name')->label(__('main.name'))->searchable(),
                TextColumn::make('description')->label(__('main.description'))->limit(50),
                TextColumn::make('status')
                    ->label(__('main.status'))
                    ->getStateUsing(fn(Course $record) => $record->status ? __('main.active') : __('main.disable'))
                    ->badge()
                    ->color(fn(string $record) => $record->status ? 'success' : 'danger'),
                TextColumn::make('created_at')->label(__('main.created_at'))->dateTime(),
                TextColumn::make('creator.name')->label(__('main.created_by'))->getStateUsing(fn(Course $record) => $record->creator->name . ' ' . $record->creator->surname),

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
