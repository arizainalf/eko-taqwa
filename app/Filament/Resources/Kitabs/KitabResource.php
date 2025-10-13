<?php
namespace App\Filament\Resources\Kitabs;

use UnitEnum;
use BackedEnum;
use App\Models\Kitab;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Kitabs\Pages\EditKitab;
use App\Filament\Resources\Kitabs\Pages\ListKitabs;
use App\Filament\Resources\Kitabs\Pages\CreateKitab;
use App\Filament\Resources\Kitabs\Schemas\KitabForm;
use App\Filament\Resources\Kitabs\Tables\KitabsTable;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class KitabResource extends Resource
{
    protected static ?string $model = Kitab::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Book;
    protected static string|UnitEnum|null $navigationGroup  = 'Eko Ayat Hadist';

    protected static ?string $recordTitleAttribute = 'kitab';

    public static function form(Schema $schema): Schema
    {
        return KitabForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KitabsTable::configure($table);
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
            'index'  => ListKitabs::route('/'),
            'create' => CreateKitab::route('/create'),
            'edit'   => EditKitab::route('/{record}/edit'),
        ];
    }
}
