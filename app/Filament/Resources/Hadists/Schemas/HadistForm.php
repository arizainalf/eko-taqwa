<?php
namespace App\Filament\Resources\Hadists\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HadistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tema_id')
                    ->relationship('tema', 'nama')
                    ->required(),
                Textarea::make('hadist')
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
