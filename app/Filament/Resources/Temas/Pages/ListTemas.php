<?php
namespace App\Filament\Resources\Temas\Pages;

use App\Filament\Resources\Temas\TemaResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTemas extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = TemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah')
                ->icon('heroicon-o-plus'),
            Action::make('bulkCreate')
                ->label('Tambah Banyak')
                ->icon('heroicon-o-queue-list')
                ->url(static::getResource()::getUrl('mass-create-tema')),
        ];
    }
}
