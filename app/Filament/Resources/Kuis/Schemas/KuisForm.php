<?php
namespace App\Filament\Resources\Kuis\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class KuisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                TextInput::make('batas_waktu')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('aktif')
                    ->required(),
            ]);
    }
}
