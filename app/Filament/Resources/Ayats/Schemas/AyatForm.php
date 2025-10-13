<?php
namespace App\Filament\Resources\Ayats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AyatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tema_id')
                    ->label('Tema')
                    ->relationship('tema', 'nama')
                    ->required(),
                Textarea::make('ayat')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('terjemahan')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('penjelasan')
                    ->columnSpanFull(),
            ]);
    }
}
