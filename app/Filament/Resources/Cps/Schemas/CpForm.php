<?php
namespace App\Filament\Resources\Cps\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('fase_id')
                    ->label('Fase')
                    ->relationship('fase', 'nama')
                    ->required(),
                Select::make('mapel_id')
                    ->label('Mapel')
                    ->relationship('mapel', 'nama')
                    ->required(),
                Textarea::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('pendekatan'),
                Textarea::make('model'),
                Textarea::make('teknik'),
                Textarea::make('metode'),
                Textarea::make('taktik'),
            ]);
    }
}
