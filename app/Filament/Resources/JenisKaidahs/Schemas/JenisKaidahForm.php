<?php

namespace App\Filament\Resources\JenisKaidahs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JenisKaidahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
