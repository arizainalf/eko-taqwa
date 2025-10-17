<?php
namespace App\Filament\Resources\Kaidahs;

use App\Filament\Resources\Kaidahs\Pages\CreateKaidah;
use App\Filament\Resources\Kaidahs\Pages\EditKaidah;
use App\Filament\Resources\Kaidahs\Pages\ListKaidahs;
use App\Filament\Resources\Kaidahs\Pages\MassCreateKaidah;
use App\Filament\Resources\Kaidahs\Schemas\KaidahForm;
use App\Filament\Resources\Kaidahs\Tables\KaidahsTable;
use App\Models\Kaidah;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class KaidahResource extends Resource
{
    protected static ?string $model = Kaidah::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Scale;

    protected static string|UnitEnum|null $navigationGroup = 'Eko Kaidah';

    protected static ?string $recordTitleAttribute = 'kaidah';

    public static function form(Schema $schema): Schema
    {
        return KaidahForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KaidahsTable::configure($table);
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
            'index'              => ListKaidahs::route('/'),
            'create'             => CreateKaidah::route('/create'),
            'edit'               => EditKaidah::route('/{record}/edit'),
            'mass-create-kaidah' => MassCreateKaidah::route('/mass-create-kaidah'),

        ];
    }
}
