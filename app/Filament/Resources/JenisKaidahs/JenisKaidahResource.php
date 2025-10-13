<?php

namespace App\Filament\Resources\JenisKaidahs;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\JenisKaidah;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\JenisKaidahs\Pages\EditJenisKaidah;
use App\Filament\Resources\JenisKaidahs\Pages\ListJenisKaidahs;
use App\Filament\Resources\JenisKaidahs\Pages\CreateJenisKaidah;
use App\Filament\Resources\JenisKaidahs\Schemas\JenisKaidahForm;
use App\Filament\Resources\JenisKaidahs\Tables\JenisKaidahsTable;

class JenisKaidahResource extends Resource
{
    protected static ?string $model = JenisKaidah::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Columns4;

    protected static string|UnitEnum|null $navigationGroup = 'Eko Kaidah';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return JenisKaidahForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisKaidahsTable::configure($table);
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
            'index' => ListJenisKaidahs::route('/'),
            'create' => CreateJenisKaidah::route('/create'),
            'edit' => EditJenisKaidah::route('/{record}/edit'),
        ];
    }
}
