<?php
namespace App\Filament\Resources\Refleksis;

use App\Filament\Resources\Refleksis\Pages\ListRefleksis;
use App\Filament\Resources\Refleksis\Schemas\RefleksiForm;
use App\Filament\Resources\Refleksis\Tables\RefleksisTable;
use App\Models\Refleksi;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class RefleksiResource extends Resource
{
    protected static ?string $model = Refleksi::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::NotebookPen;

    protected static string|UnitEnum|null $navigationGroup = 'Eko Refleksi';
    protected static ?string $recordTitleAttribute             = 'judul';

    public static function form(Schema $schema): Schema
    {
        return RefleksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RefleksisTable::configure($table);
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
            'index' => ListRefleksis::route('/'),
        ];
    }
}
