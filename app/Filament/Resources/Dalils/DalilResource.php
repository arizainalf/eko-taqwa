<?php
namespace App\Filament\Resources\Dalils;

use App\Filament\Resources\Dalils\Pages\CreateDalil;
use App\Filament\Resources\Dalils\Pages\EditDalil;
use App\Filament\Resources\Dalils\Pages\ListDalils;
use App\Filament\Resources\Dalils\Pages\MassCreateDalil;
use App\Filament\Resources\Dalils\Schemas\DalilForm;
use App\Filament\Resources\Dalils\Tables\DalilsTable;
use App\Models\Dalil;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DalilResource extends Resource
{
    protected static ?string $model = Dalil::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookText;

    protected static string|UnitEnum|null $navigationGroup = 'Eko Ayat Hadist';

    protected static ?string $recordTitleAttribute = 'teks_asli';

    protected static ?string $slug = 'dalil';

    public static function form(Schema $schema): Schema
    {
        return DalilForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DalilsTable::configure($table);
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
            'index'             => ListDalils::route('/'),
            'create'            => CreateDalil::route('/create'),
            'edit'              => EditDalil::route('/{record}/edit'),
            'mass-create-dalil' => MassCreateDalil::route('/mass-create-dalil'),
        ];
    }
}
