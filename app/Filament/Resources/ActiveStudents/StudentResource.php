<?php

namespace App\Filament\Resources\ActiveStudents;

use App\Filament\Resources\ActiveStudents\RelationManagers\GroupsRelationManager;
use App\Filament\Resources\ActiveStudents\RelationManagers\GroupsTeachingRelationManager;
use App\Filament\Resources\ActiveStudents\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'students';
    protected static ?string $navigationLabel = 'Aktiv tələbələr';
    protected static string|UnitEnum|null $navigationGroup = 'Tələbələr';
    protected static ?string $label = 'Aktiv tələbə';

    protected static string|BackedEnum|null $navigationIcon = Phosphor::StudentDuotone;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            GroupsRelationManager::class,
            GroupsTeachingRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->role('student')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
