<?php
namespace App\Filament\Resources\Fases\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Fase')
                    ->description('Masukkan data Fase')
                    ->schema([
                        TextInput::make('nama')
                            ->required(),
                        Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull() // Bisa juga diberi kolom
                    ->collapsible(),
            ]);
    }
}
