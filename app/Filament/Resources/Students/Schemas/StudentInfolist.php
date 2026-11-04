<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Filament\Resources\Users\Schemas\UserInfolist;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }
}
