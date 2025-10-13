<?php
namespace App\Filament\Resources\Hadists;

use App\Filament\Resources\Hadists\Pages\CreateHadist;
use App\Filament\Resources\Hadists\Pages\EditHadist;
use App\Filament\Resources\Hadists\Pages\ListHadists;
use App\Filament\Resources\Hadists\Schemas\HadistForm;
use App\Filament\Resources\Hadists\Tables\HadistsTable;
use App\Models\Hadist;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class HadistResource extends Resource
{
    protected static ?string $model = Hadist::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookMarked;

    protected static string|UnitEnum|null $navigationGroup = 'Eko Ayat Hadist';

    protected static ?string $recordTitleAttribute = 'hadist';

    public static function form(Schema $schema): Schema
    {
        return HadistForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HadistsTable::configure($table);
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
            'index'  => ListHadists::route('/'),
            'create' => CreateHadist::route('/create'),
            'edit'   => EditHadist::route('/{record}/edit'),
        ];
    }
}
