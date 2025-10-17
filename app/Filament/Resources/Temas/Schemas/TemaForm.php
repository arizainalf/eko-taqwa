<?php
namespace App\Filament\Resources\Temas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TemaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tema')
                    ->description('Masukkan data Tema.')
                    ->schema([
                        Select::make('jenis_tema_id')
                            ->required()
                            ->label('Jenis Tema')
                            ->relationship('jenistema', 'nama'),
                        TextInput::make('nama')
                            ->label('Nama Tema')
                            ->required(),
                        Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(), // Bisa juga diberi kolom,
            ]);
    }
}
