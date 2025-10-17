<?php
namespace App\Filament\Resources\Cps\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Capaian Pembelajaran')
                    ->description('Masukkan data Capaian Pembelajaran.')
                    ->schema([
                        Select::make('fase_id')
                            ->label('Fase')
                            ->relationship('fase', 'nama')
                            ->required(),
                        Select::make('mapel_id')
                            ->label('Mapel')
                            ->relationship('mapel', 'nama')
                            ->required(),
                        Select::make('metode_pembelajaran')
                            ->label('Metode Pembelajaran'
                            )->options([
                            'sekolah' => 'Di Sekolah',
                            'rumah'   => 'Di Rumah'])
                            ->default('sekolah')
                            ->required(),
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->label('Judul CP'),
                        Textarea::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('pendekatan'),
                        Textarea::make('model'),
                        Textarea::make('teknik'),
                        Textarea::make('metode'),
                        Textarea::make('taktik'),
                    ])
                    ->columnSpanFull() // Bisa juga diberi kolom
                    ->collapsible(),
            ]);
    }
}
