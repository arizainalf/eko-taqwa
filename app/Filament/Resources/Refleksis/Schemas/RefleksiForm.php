<?php
namespace App\Filament\Resources\Refleksis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RefleksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('device_id')
                    ->relationship('device', 'name')
                    ->required(),
                FileUpload::make('gambar')
                    ->image()
                    ->directory(directory: 'refleksi')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048),
                DatePicker::make('tanggal')
                    ->required()
                    ->default(now()),
                Textarea::make('judul')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
