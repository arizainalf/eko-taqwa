<?php
namespace App\Filament\Resources\Pertanyaans\Schemas;

use App\Models\Kuis;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PertanyaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pertanyaan')
                    ->description('Masukkan data Pertanyaan.')
                    ->schema([
                        Select::make('kuis_id')
                            ->label('Kuis')
                            ->relationship('kuis', 'judul')
                            ->options(Kuis::pluck('judul', 'id'))
                            ->required(),
                        Textarea::make('teks_pertanyaan')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),
            ]);
    }
}
