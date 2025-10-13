<?php

namespace App\Filament\Resources\Kaidahs\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Kaidahs\KaidahResource;

class ListKaidahs extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = KaidahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
