<?php
namespace App\Filament\Resources\Devices\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('device_id')
                    ->label('Device Id')
                    ->required(),
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
            ]);
    }
}
