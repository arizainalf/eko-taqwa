<?php
namespace App\Filament\Resources\Pertanyaans;

use App\Filament\Resources\Pertanyaans\Pages\EditPertanyaan;
use App\Filament\Resources\Pertanyaans\Pages\ListPertanyaans;
use App\Filament\Resources\Pertanyaans\RelationManagers\OpsipertanyaanRelationManager;
use App\Filament\Resources\Pertanyaans\Schemas\PertanyaanForm;
use App\Filament\Resources\Pertanyaans\Tables\PertanyaansTable;
use App\Models\Pertanyaan;
use BackedEnum;
use UnitEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PertanyaanResource extends Resource
{
    protected static ?string $model = Pertanyaan::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::CircleQuestionMark;

    protected static string|UnitEnum|null $navigationGroup = 'Eko Refleksi';
    protected static ?string $recordTitleAttribute             = 'teks_pertanyaan';

    public static function form(Schema $schema): Schema
    {
        return PertanyaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PertanyaansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            OpsipertanyaanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPertanyaans::route('/'),
            // 'create' => CreatePertanyaan::route('/create'),
            'edit'  => EditPertanyaan::route('/{record}/edit'),
        ];
    }
}
