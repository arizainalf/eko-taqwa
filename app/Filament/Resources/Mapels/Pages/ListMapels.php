<?php
namespace App\Filament\Resources\Mapels\Pages;

use App\Filament\Resources\Mapels\MapelResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMapels extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = MapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
            Action::make('bulkCreate')
                ->label('Tambah Banyak')
                ->icon('heroicon-o-queue-list')
                ->url(static::getResource()::getUrl('mass-create-mapel')),
        ];
    }
}
