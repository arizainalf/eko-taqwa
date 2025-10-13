<?php
namespace App\Filament\Resources\Devices;

use UnitEnum;
use BackedEnum;
use App\Models\Device;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Devices\Pages\EditDevice;
use App\Filament\Resources\Devices\Pages\ListDevices;
use App\Filament\Resources\Devices\Pages\CreateDevice;
use App\Filament\Resources\Devices\Schemas\DeviceForm;
use App\Filament\Resources\Devices\Tables\DevicesTable;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Smartphone;
    protected static string|UnitEnum|null $navigationGroup  = 'User Management';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DeviceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DevicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDevices::route('/'),
            'create' => CreateDevice::route('/create'),
            'edit'   => EditDevice::route('/{record}/edit'),
        ];
    }
}
