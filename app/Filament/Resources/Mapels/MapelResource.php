<?php
namespace App\Filament\Resources\Mapels;

use UnitEnum;
use BackedEnum;
use App\Models\Mapel;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Mapels\Pages\EditMapel;
use App\Filament\Resources\Mapels\Pages\ListMapels;
use App\Filament\Resources\Mapels\Schemas\MapelForm;
use App\Filament\Resources\Mapels\Tables\MapelsTable;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class MapelResource extends Resource
{
    protected static ?string $model = Mapel::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Library;

    protected static string|UnitEnum|null $navigationGroup = 'Eko CP';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MapelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MapelsTable::configure($table);
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
            'index' => ListMapels::route('/'),
            'edit'  => EditMapel::route('/{record}/edit'),
        ];
    }
}
