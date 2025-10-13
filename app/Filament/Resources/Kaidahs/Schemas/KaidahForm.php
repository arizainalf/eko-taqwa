<?php
namespace App\Filament\Resources\Kaidahs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class KaidahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tema_id')
                    ->relationship('tema', 'nama')
                    ->required(),
                Select::make('jenis_kaidah_id')
                    ->relationship('jeniskaidah', 'nama')
                    ->required(),
                Textarea::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
