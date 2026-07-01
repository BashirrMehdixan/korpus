<?php

namespace App\Filament\Resources\Teachers\RelationManagers;

use App\Models\Course;
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
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupsTeachingRelationManager extends RelationManager
{
    protected static string $relationship = 'groupsTeaching';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->reactive(),

                Select::make('course_id')
                    ->label('Course')
                    ->options(fn() => Course::where('status', true)->get()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->native(false)
                    ->required(),

                DatePicker::make('end_date')
                    ->label('End Date')
                    ->native(false)
                    ->required(),
                Section::make('Payment Method select')->schema([
                    ToggleButtons::make('payment_method')
                        ->label('Ödəniş üsulu')
                        ->options([
                            1 => 'Birdəfəlik',
                            2 => 'Aylıq',
                        ])
                        ->default(1)
                        ->inline()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            if ($state === 1) {
                                $set('monthly_amount', null);
                            } else {
                                $set('fixed_amount', null);
                            }
                        }),
                    TextInput::make('fixed_amount')
                        ->label('Birdəfəlik məbləğ (AZN)')
                        ->numeric()
                        ->visible(fn($get) => $get('payment_method') === 1)
                        ->required(fn($get) => $get('payment_method') === 1),
                    TextInput::make('monthly_amount')
                        ->label('Aylıq məbləğ (AZN)')
                        ->numeric()
                        ->visible(fn($get) => $get('payment_method') === 2)
                        ->required(fn($get) => $get('payment_method') === 2),
                ])->columnSpanFull(),

                ToggleButtons::make('status')
                    ->label('Status')
                    ->grouped()
                    ->inline()
                    ->boolean()->default(true),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('Id'),

                TextEntry::make('name')
                    ->label('Name'),

                TextEntry::make('slug')
                    ->label('Slug'),

                TextEntry::make('course.name')
                    ->label('Course Id'),

                TextEntry::make('start_date')
                    ->label('Start Date')
                    ->dateTime(),

                TextEntry::make('end_date')
                    ->label('End Date')
                    ->dateTime(),

                TextEntry::make('payment_method')
                    ->label('Ödəniş üsulu')
                    ->getStateUsing(fn($state) => $state === 1 ? 'Birdəfəlik' : 'Aylıq'),

                TextEntry::make('amount')
                    ->label('Məbləğ (AZN)')
                    ->getStateUsing(fn($record) => $record->payment_method === 1 ? $record->fixed_amount : $record->monthly_amount)
                    ->money('AZN'),

                TextEntry::make('status')
                    ->label('Aktivlik')
                    ->badge()
                    ->getStateUsing(fn($state) => $state ? 'Aktiv' : 'Passiv'),

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
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('course.name')
                    ->label('Course Id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date(),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date(),

                TextColumn::make('payment_method')
                    ->label('Ödəniş üsulu')
                    ->getStateUsing(fn($record) => $record->payment_method === 1 ? 'Birdəfəlik' : 'Aylıq'),

                TextColumn::make('amount')
                    ->label('Məbləğ (AZN)')
                    ->getStateUsing(fn($record) => $record->payment_method === 1 ? $record->fixed_amount : $record->monthly_amount)
                    ->money('AZN'),

                TextColumn::make('status')
                    ->label('Aktivlik')
                    ->getStateUsing(fn($record) => $record->status ? 'Aktiv' : 'Passiv')
                    ->badge()
                    ->color(fn(string $state) => $state === 'Aktiv' ? 'success' : 'danger'),
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
