<?php

namespace App\Filament\Resources\Refleksis\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;
use App\Filament\Resources\Refleksis\RefleksiResource;

class ListRefleksis extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = RefleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
