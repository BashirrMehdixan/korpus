<?php

namespace App\Filament\Resources\Groups;

use App\Filament\Resources\Groups\Pages\CreateGroup;
use App\Filament\Resources\Groups\Pages\EditGroup;
use App\Filament\Resources\Groups\Pages\ListGroups;
use App\Filament\Resources\Groups\Schemas\GroupForm;
use App\Filament\Resources\Groups\Schemas\GroupInfolist;
use App\Filament\Resources\Groups\Tables\GroupsTable;
use App\Models\Group;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $slug = 'groups';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Qruplar';

    protected static ?string $modelLabel = 'Qrup';

    protected static ?string $pluralModelLabel = 'Qruplar';

    public static function form(Schema $schema): Schema
    {
        return GroupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupsTable::table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'create' => CreateGroup::route('/create'),
            'edit' => EditGroup::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        $user = auth()->user();
        if ($user && !$user->hasRole('super_admin')) {
            if ($user->hasRole('teacher')) {
                $query->where('teacher_id', $user->id);
            } elseif ($user->hasRole('student')) {
                $query->whereHas('students', fn(Builder $q) => $q->where('user_id', $user->id));
            }
        }

        return $query;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }
}
