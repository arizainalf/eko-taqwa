<?php

namespace App\Filament\Resources\Kitabs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class KitabForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make('tema_id')
                    ->relationship('tema', 'nama')
                    ->required(),
                TextInput::make('kitab')
                    ->required(),
                Textarea::make('penjelasan')
                    ->columnSpanFull(),
            ]);
    }
}
