<?php
namespace App\Filament\Resources\Kuis\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KuisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kuis')
                    ->description('Masukkan data Kuis.')
                    ->schema([
                        TextInput::make('judul')
                            ->required(),
                        Textarea::make('deskripsi')
                            ->columnSpanFull(),
                        TextInput::make('batas_waktu')
                            ->required()
                            ->numeric()
                            ->suffix('Menit')
                            ->default(60),
                        Toggle::make('aktif')
                            ->required(),
                    ])->columnSpanFull(),
            ]);
    }
}
