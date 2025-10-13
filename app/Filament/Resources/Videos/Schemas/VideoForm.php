<?php
namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tema_id')
                    ->required()
                    ->relationship('tema', 'nama'),
                TextInput::make('judul')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                TextInput::make('link')
                    ->required(),
            ]);
    }
}
