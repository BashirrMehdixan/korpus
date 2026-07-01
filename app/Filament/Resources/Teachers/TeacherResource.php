<?php

namespace App\Filament\Resources\Teachers;

use App\Filament\Resources\Teachers\RelationManagers\GroupsTeachingRelationManager;
use App\Filament\Resources\Teachers\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\Teachers\RelationManagers\TeacherPaymentTypesRelationManager;
use App\Filament\Resources\Teachers\Schemas\TeacherInfolist;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'teachers';
    protected static ?string $label = 'Müəllim';
    protected static ?string $navigationLabel = 'Müəllimlər';
    protected static ?string $pluralLabel = 'Müəllim';

    protected static string|BackedEnum|null $navigationIcon = Phosphor::ChalkboardDuotone;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TeacherInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            GroupsTeachingRelationManager::class,
            PaymentsRelationManager::class,
            TeacherPaymentTypesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->role('teacher')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
