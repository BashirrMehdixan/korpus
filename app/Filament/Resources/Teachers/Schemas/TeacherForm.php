<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Filament\Resources\Users\Schemas\UserForm;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return UserForm::configure($schema, defaultRole: 'teacher');
    }
}
