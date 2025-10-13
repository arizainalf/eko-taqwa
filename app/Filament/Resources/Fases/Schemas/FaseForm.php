<?php
namespace App\Filament\Resources\Fases\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                // TextInput::make('ikon'),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
