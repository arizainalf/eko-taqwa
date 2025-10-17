<?php
namespace App\Filament\Resources\Dalils\Pages;

use App\Filament\Resources\Dalils\DalilResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDalils extends ListRecords
{
    protected static string $resource = DalilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
            Action::make('bulkCreate')
                ->label('Tambah Banyak')
                ->icon('heroicon-o-queue-list')
                ->url(static::getResource()::getUrl('mass-create-dalil')),
        ];
    }
}
