<?php

namespace App\Filament\Resources\HasilKuis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HasilKuisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('device_id')
                    ->required(),
                TextInput::make('kuis_id')
                    ->required(),
                TextInput::make('skor')
                    ->required()
                    ->numeric(),
                TextInput::make('total_pertanyaan')
                    ->required()
                    ->numeric(),
                TextInput::make('jawaban_benar')
                    ->required()
                    ->numeric(),
                TextInput::make('jawaban_salah')
                    ->required()
                    ->numeric(),
                TextInput::make('waktu_pengerjaan')
                    ->required()
                    ->numeric(),
                TextInput::make('jawaban'),
            ]);
    }
}
