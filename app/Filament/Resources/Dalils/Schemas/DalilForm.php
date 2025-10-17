<?php
namespace App\Filament\Resources\Dalils\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DalilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dalil')
                    ->description('Masukkan data Dalil Ayat / Hadist.')
                    ->schema([
                        Select::make('tema_id')
                            ->required()
                            ->label('Tema')
                            ->relationship('tema', 'nama'),
                        Select::make('jenis')
                            ->options(['ayat' => 'Ayat', 'hadist' => 'Hadist'])
                            ->required(),
                        Textarea::make('teks_asli')
                            ->label('Teks Dalil')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('terjemahan')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('sumber')
                            ->placeholder('QS. Al-A’raf: 31 / HR. Ibnu Majah')
                            ->columnSpanFull(),
                        Textarea::make('penjelasan')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull() // Bisa juga diberi kolom
                    ->collapsible(),
            ]);
    }
}
