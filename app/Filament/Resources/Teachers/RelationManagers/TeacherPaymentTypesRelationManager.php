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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherPaymentTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'teacherPaymentTypes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ToggleButtons::make('type')
                    ->label('Ödəniş növü')
                    ->options([
                        1 => 'Standart maaş',
                        2 => 'Şagird sayına görə',
                        3 => 'Faiz dərəcəsi',
                    ])
                    ->inline()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('amount', null)),
                ToggleButtons::make('payment_method')
                    ->label('Ödəniş metodu')
                    ->options([
                        1 => 'Birdəfəlik',
                        2 => 'Aylıq',
                    ])
                    ->inline()
                    ->nullable(),
                TextInput::make('amount')
                    ->label('Məbləğ')
                    ->numeric()
                    ->visible(fn($get) => in_array($get('type'), [1, 2]))
                    ->required(fn($get) => in_array($get('type'), [1, 2])),
                TextInput::make('percentage')
                    ->label('Faiz (%)')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 3)
                    ->required(fn($get) => $get('type') === 3),
                Select::make('group_id')
                    ->label('Qrup')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                ToggleButtons::make('status')
                    ->label('Aktivlik')
                    ->boolean()
                    ->inline()
                    ->default(true),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')
                    ->label('Ödəniş növü')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Standart maaş',
                        2 => 'Şagird sayına görə',
                        3 => 'Faiz dərəcəsi',
                        default => 'Bilinmir',
                    }),
                TextEntry::make('payment_method')
                    ->label('Ödəniş metodu')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Birdəfəlik',
                        2 => 'Aylıq',
                        default => 'Təyin edilməyib',
                    }),
                TextEntry::make('amount')
                    ->label('Məbləğ'),
                TextEntry::make('percentage')
                    ->label('Faiz (%)'),
                TextEntry::make('group.name')
                    ->label('Qrup'),
                TextEntry::make('status')
                    ->label('Aktivlik')
                    ->formatStateUsing(fn($state) => $state ? 'Aktiv' : 'Passiv'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('type')
                    ->label('Ödəniş növü')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Standart maaş',
                        2 => 'Şagird sayına görə',
                        3 => 'Faiz dərəcəsi',
                        default => 'Bilinmir',
                    }),
                TextColumn::make('payment_method')
                    ->label('Ödəniş metodu')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Birdəfəlik',
                        2 => 'Aylıq',
                        default => '-',
                    }),
                TextColumn::make('amount')
                    ->label('Məbləğ'),
                TextColumn::make('percentage')
                    ->label('Faiz (%)'),
                TextColumn::make('group.name')
                    ->label('Qrup'),
                TextColumn::make('status')
                    ->label('Aktivlik')
                    ->formatStateUsing(fn($state) => $state ? 'Aktiv' : 'Passiv')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
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
