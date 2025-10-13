<?php

namespace App\Filament\Resources\Hadists\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Hadists\HadistResource;

class ListHadists extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = HadistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
