<?php
namespace App\Filament\Resources\Pertanyaans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PertanyaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kuis_id')
                    ->label('Kuis')
                    ->relationship('kuis', 'judul')
                    ->required(),
                Textarea::make('teks_pertanyaan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
