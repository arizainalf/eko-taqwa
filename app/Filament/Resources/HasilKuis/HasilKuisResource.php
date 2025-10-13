<?php
namespace App\Filament\Resources\HasilKuis;

use UnitEnum;
use BackedEnum;
use App\Models\HasilKuis;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\HasilKuis\Pages\EditHasilKuis;
use App\Filament\Resources\HasilKuis\Pages\ListHasilKuis;
use App\Filament\Resources\HasilKuis\Pages\CreateHasilKuis;
use App\Filament\Resources\HasilKuis\Schemas\HasilKuisForm;
use App\Filament\Resources\HasilKuis\Tables\HasilKuisTable;

class HasilKuisResource extends Resource
{
    protected static ?string $model = HasilKuis::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::ClipboardCheck;
    protected static string|UnitEnum|null $navigationGroup  = 'Eko Refleksi';

    public static function form(Schema $schema): Schema
    {
        return HasilKuisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HasilKuisTable::configure($table);
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
            'index'  => ListHasilKuis::route('/'),
            // 'create' => CreateHasilKuis::route('/create'),
            // 'edit'   => EditHasilKuis::route('/{record}/edit'),
        ];
    }
}
