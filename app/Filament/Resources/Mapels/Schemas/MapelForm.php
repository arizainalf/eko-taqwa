<?php
namespace App\Filament\Resources\Mapels\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MapelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Mata Pelajaran")
                    ->description("Masukan data Mata Pelajaran")
                    ->schema([
                        TextInput::make('nama')
                            ->required(),
                        Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
