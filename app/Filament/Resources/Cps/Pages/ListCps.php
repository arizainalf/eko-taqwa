<?php

namespace App\Filament\Resources\Cps\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Cps\CpResource;
use Asmit\ResizedColumn\HasResizableColumn;

class ListCps extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = CpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
