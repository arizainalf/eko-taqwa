<?php
namespace App\Filament\Resources\Temas;

use App\Filament\Resources\Temas\Pages\ListTemas;
use App\Filament\Resources\Temas\Schemas\TemaForm;
use App\Filament\Resources\Temas\Tables\TemasTable;
use App\Models\Tema;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class TemaResource extends Resource
{
    protected static ?string $model = Tema::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Palette;
    protected static string|UnitEnum|null $navigationGroup  = 'Tema';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return TemaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TemasTable::configure($table);
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
            'index' => ListTemas::route('/'),
        ];
    }
}
