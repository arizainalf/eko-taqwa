<?php
namespace App\Filament\Resources\Kuis\RelationManagers;

use App\Filament\Resources\Pertanyaans\PertanyaanResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PertanyaanRelationManager extends RelationManager
{
    protected static string $relationship = 'pertanyaan';

    protected static ?string $label           = 'Pertanyaan';
    protected static ?string $relatedResource = PertanyaanResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->icon('heroicon-o-plus')
                    ->label('Tambah Pertanyaan'),
                Action::make('bulkCreate')
                    ->label('Tambah Banyak Pertanyaan')
                    ->icon('heroicon-o-queue-list')
                    ->url(PertanyaanResource::getUrl('mass-create-pertanyaan')),
            ]);
    }

}
