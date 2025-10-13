<?php
namespace App\Filament\Resources\Temas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TemaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_tema_id')
                    ->required()
                    ->label('Jenis Tema')
                    ->relationship('jenistema', 'nama'),
                TextInput::make('nama')
                    ->label('Nama Tema')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
