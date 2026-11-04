<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Filament\Resources\Users\Schemas\UserInfolist;
use Filament\Schemas\Schema;

class TeacherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }
}
