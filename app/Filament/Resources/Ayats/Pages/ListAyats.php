<?php

namespace App\Filament\Resources\Ayats\Pages;

use App\Filament\Resources\Ayats\AyatResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAyats extends ListRecords
{
    use HasResizableColumn;
    protected static string $resource = AyatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
