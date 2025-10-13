<?php

namespace App\Filament\Resources\JenisKaidahs\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\JenisKaidahs\JenisKaidahResource;

class ListJenisKaidahs extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = JenisKaidahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
