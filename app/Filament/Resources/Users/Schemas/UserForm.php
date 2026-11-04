<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Schemas\Components\JsForm;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema, ?string $defaultRole = null): Schema
    {
        return $schema
            ->components([
                JsForm::make()
                    ->columnSpanFull()
                    ->configuration([
                        'defaultRole' => $defaultRole,
                    ]),
            ]);
    }
}
