<?php
namespace App\Filament\Resources\Devices\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Device')
                    ->description('Masukkan data Device.')
                    ->schema([
                        Repeater::make('device')
                            ->schema([
                                TextInput::make('device_id')
                                    ->label('Device Id')
                                    ->required(),
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->required(),
                            ])
                            ->columns(1)
                            ->addActionLabel('Tambah Device')
                            ->collapsible() // Agar bisa diciutkan
                            ->defaultItems(1),
                    ])
                    ->columnSpanFull() // Bisa juga diberi kolom
                    ->collapsible(),
            ]);
    }
}
