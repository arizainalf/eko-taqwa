<?php
namespace App\Filament\Resources\Kuis;

use App\Filament\Resources\Kuis\Pages\CreateKuis;
use App\Filament\Resources\Kuis\Pages\EditKuis;
use App\Filament\Resources\Kuis\Pages\ListKuis;
use App\Filament\Resources\Kuis\RelationManagers\PertanyaanRelationManager;
use App\Filament\Resources\Kuis\Schemas\KuisForm;
use App\Filament\Resources\Kuis\Tables\KuisTable;
use App\Models\Kuis;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class KuisResource extends Resource
{
    protected static ?string $model = Kuis::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::FileQuestionMark;
    protected static string|UnitEnum|null $navigationGroup  = 'Eko Refleksi';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return KuisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KuisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PertanyaanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListKuis::route('/'),
            'create' => CreateKuis::route('/create'),
            'edit'   => EditKuis::route('/{record}/edit'),
        ];
    }
}
