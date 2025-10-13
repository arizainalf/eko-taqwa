<?php

namespace App\Filament\Resources\JenisTemas\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\JenisTemas\JenisTemaResource;

class ListJenisTemas extends ListRecords
{
    use HasResizableColumn;
    protected static string $resource = JenisTemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
