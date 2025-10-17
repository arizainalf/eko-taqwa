<?php
namespace App\Filament\Resources\Cps\Pages;

use App\Filament\Resources\Cps\CpResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCps extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = CpResource::class;
    protected static ?string $title   = 'Capaian Pembelajaran';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
            Action::make('bulkCreate')
                ->label('Tambah Banyak')
                ->icon('heroicon-o-queue-list')
                ->url(static::getResource()::getUrl('mass-create-cp')),
        ];
    }
}
