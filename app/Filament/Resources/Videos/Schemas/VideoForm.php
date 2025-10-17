<?php
namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Video')
                    ->description('Masukkan data Video.')
                    ->schema([
                        Select::make('tema_id')
                            ->label('Tema')
                            ->required()
                            ->relationship('tema', 'nama'),
                        TextInput::make('judul')
                            ->required(),
                        Textarea::make('deskripsi')
                            ->nullable()
                            ->columnSpanFull(),
                        TextInput::make('link')
                            ->required(),
                    ])
                    ->columnSpanFull(), // Bisa juga diberi kolom,
            ]);
    }
}
