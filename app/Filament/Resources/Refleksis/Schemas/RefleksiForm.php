<?php
namespace App\Filament\Resources\Refleksis\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class RefleksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('device_id')
                    ->relationship('device', 'name')
                    ->required(),
                TextInput::make('gambar'),
                Textarea::make('judul')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
