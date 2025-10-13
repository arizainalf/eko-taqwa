<?php

namespace App\Filament\Resources\Ayats;

use UnitEnum;
use BackedEnum;
use App\Models\Ayat;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Ayats\Pages\EditAyat;
use App\Filament\Resources\Ayats\Pages\ListAyats;
use App\Filament\Resources\Ayats\Pages\CreateAyat;
use App\Filament\Resources\Ayats\Schemas\AyatForm;
use App\Filament\Resources\Ayats\Tables\AyatsTable;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class AyatResource extends Resource
{
    protected static ?string $model = Ayat::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookText;

    protected static string|UnitEnum|null $navigationGroup = 'Eko Ayat Hadist';

    public static function form(Schema $schema): Schema
    {
        return AyatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AyatsTable::configure($table);
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
            'index' => ListAyats::route('/'),
            'create' => CreateAyat::route('/create'),
            'edit' => EditAyat::route('/{record}/edit'),
        ];
    }
}
