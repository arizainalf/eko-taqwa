<?php

namespace App\Filament\Resources\Fases\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Fases\FaseResource;

class ListFases extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = FaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
