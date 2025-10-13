<?php

namespace App\Filament\Resources\Kuis\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Kuis\KuisResource;

class ListKuis extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = KuisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
