<?php
namespace App\Filament\Resources\JenisTemas\Schemas;

use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JenisTemaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jenis Tema')
                    ->label('Masukan data Jenis Tema')
                    ->icon(LucideIcon::SquareLibrary)
                    ->columns(1)
                    ->schema([
                        TextInput::make('nama')
                            ->required(),
                        Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(), // Bisa juga diberi kolom
            ]);
    }
}
