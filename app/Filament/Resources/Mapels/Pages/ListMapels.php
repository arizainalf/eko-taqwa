<?php

namespace App\Filament\Resources\Mapels\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Mapels\MapelResource;

class ListMapels extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = MapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
