<?php
namespace App\Filament\Resources\JenisTemas;

use App\Filament\Resources\JenisTemas\Pages\CreateJenisTema;
use App\Filament\Resources\JenisTemas\Pages\EditJenisTema;
use App\Filament\Resources\JenisTemas\Pages\ListJenisTemas;
use App\Filament\Resources\JenisTemas\RelationManagers\TemaRelationManager;
use App\Filament\Resources\JenisTemas\Schemas\JenisTemaForm;
use App\Filament\Resources\JenisTemas\Tables\JenisTemasTable;
use App\Models\JenisTema;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class JenisTemaResource extends Resource
{
    protected static ?string $model = JenisTema::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::SquareLibrary;
    protected static string|UnitEnum|null $navigationGroup  = 'Tema';

    public static function form(Schema $schema): Schema
    {
        return JenisTemaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisTemasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TemaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'       => ListJenisTemas::route('/'),
            'create'      => CreateJenisTema::route('/create'),
            'edit'        => EditJenisTema::route('/{record}/edit'),
            'bulk-create' => Pages\CreateBulk::route('/bulk-create'),
        ];
    }
}
