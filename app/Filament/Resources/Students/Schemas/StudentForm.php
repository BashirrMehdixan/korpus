<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Filament\Resources\Users\Schemas\UserForm;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return UserForm::configure($schema, defaultRole: 'student');
    }
}
