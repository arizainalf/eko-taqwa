<?php
namespace App\Filament\Resources\Kaidahs\Pages;

use App\Filament\Resources\Kaidahs\KaidahResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKaidahs extends ListRecords
{
    use HasResizableColumn;
    protected static string $resource = KaidahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
            Action::make('bulkCreate')
                ->label('Tambah Banyak')
                ->icon('heroicon-o-queue-list')
                ->url(static::getResource()::getUrl('mass-create-kaidah')),
        ];
    }
}
