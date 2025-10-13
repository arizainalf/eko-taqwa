<?php

namespace App\Filament\Resources\HasilKuis\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\HasilKuis\HasilKuisResource;

class ListHasilKuis extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = HasilKuisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
