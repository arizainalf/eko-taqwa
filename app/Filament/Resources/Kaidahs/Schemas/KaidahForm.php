<?php
namespace App\Filament\Resources\Kaidahs\Schemas;

use App\Models\Tema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KaidahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kaidah')
                    ->description('Masukkan data Kaidah.')
                    ->schema([
                        Select::make('tema_id')
                            ->required()
                            ->label('Tema')
                            ->options(Tema::pluck('nama', 'id')),
                        Select::make('jenis_kaidah')
                            ->options(['ushuliyah' => 'Kaidah Ushuliyah', 'fiqhiyah' => 'Kaidah Fiqhiyah'])
                            ->required(),
                        Textarea::make('kaidah')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('kaidah_latin')
                            ->nullable()
                            ->columnSpanFull(),
                        Textarea::make('terjemahan')
                            ->nullable()
                            ->columnSpanFull(),
                        Textarea::make('deskripsi')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull() // Bisa juga diberi kolom
                    ->collapsible(),
            ]);
    }
}
