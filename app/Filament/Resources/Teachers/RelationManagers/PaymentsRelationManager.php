<?php

namespace App\Filament\Resources\Teachers\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('group_id')
                    ->label('Group Id')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric(),

                DatePicker::make('paid_at')
                    ->label('Paid Date'),

                TextInput::make('month')
                    ->label('Month')
                    ->required()
                    ->integer(),

                TextInput::make('year')
                    ->label('Year')
                    ->required()
                    ->integer(),

                TextInput::make('status')
                    ->label('Status')
                    ->required(),

                TextInput::make('note')
                    ->label('Note'),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->dateTime(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('Id'),

                TextEntry::make('group.name')
                    ->label('Group Id'),

                TextEntry::make('amount')
                    ->label('Amount'),

                TextEntry::make('paid_at')
                    ->label('Paid Date')
                    ->dateTime(),

                TextEntry::make('month')
                    ->label('Month'),

                TextEntry::make('year')
                    ->label('Year'),

                TextEntry::make('status')
                    ->label('Status'),

                TextEntry::make('note')
                    ->label('Note'),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->dateTime(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('group.name')
                    ->label('Group Id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Amount'),

                TextColumn::make('paid_at')
                    ->label('Paid Date')
                    ->date(),

                TextColumn::make('month')
                    ->label('Month'),

                TextColumn::make('year')
                    ->label('Year'),

                TextColumn::make('status')
                    ->label('Status'),

                TextColumn::make('note')
                    ->label('Note'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->headerActions([
                CreateAction::make(),
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
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
