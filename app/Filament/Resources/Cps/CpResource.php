<?php
namespace App\Filament\Resources\Cps;

use UnitEnum;
use BackedEnum;
use App\Models\Cp;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Cps\Pages\EditCp;
use App\Filament\Resources\Cps\Pages\ListCps;
use App\Filament\Resources\Cps\Pages\CreateCp;
use App\Filament\Resources\Cps\Schemas\CpForm;
use App\Filament\Resources\Cps\Tables\CpsTable;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class CpResource extends Resource
{
    protected static ?string $model = Cp::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Eko CP';

    protected static ?string $navigationLabel = 'Capaian Pembelajaran';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'deskripsi';

    public static function form(Schema $schema): Schema
    {
        return CpForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CpsTable::configure($table);
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
            'index'  => ListCps::route('/'),
            'create' => CreateCp::route('/create'),
            'edit'   => EditCp::route('/{record}/edit'),
        ];
    }
}
