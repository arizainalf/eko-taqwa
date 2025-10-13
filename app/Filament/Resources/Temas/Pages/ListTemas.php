<?php

namespace App\Filament\Resources\Temas\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Temas\TemaResource;

class ListTemas extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = TemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
