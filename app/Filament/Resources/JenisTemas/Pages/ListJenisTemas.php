<?php
namespace App\Filament\Resources\JenisTemas\Pages;

use App\Filament\Resources\JenisTemas\JenisTemaResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisTemas extends ListRecords
{
    use HasResizableColumn;
    protected static string $resource = JenisTemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
            Action::make('bulkCreate')
                ->label('Tambah Banyak')
                ->icon('heroicon-o-queue-list')
                ->url(static::getResource()::getUrl('bulk-create')),
        ];
    }
}
