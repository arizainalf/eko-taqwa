<?php
namespace App\Filament\Resources\Fases\Pages;

use App\Filament\Resources\Fases\FaseResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFases extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = FaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
            Action::make('bulkCreate')
                ->label('Tambah Banyak')
                ->icon('heroicon-o-queue-list')
                ->url(static::getResource()::getUrl('mass-create-fase')),
        ];
    }
}
