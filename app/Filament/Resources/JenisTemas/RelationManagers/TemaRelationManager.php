<?php
namespace App\Filament\Resources\JenisTemas\RelationManagers;

use App\Filament\Resources\Temas\TemaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class TemaRelationManager extends RelationManager
{
    protected static string $relationship = 'tema';

    protected static ?string $relatedResource = TemaResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
