<?php

namespace App\Filament\Resources\Kitabs\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Kitabs\KitabResource;

class ListKitabs extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = KitabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
