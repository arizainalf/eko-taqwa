<?php

namespace App\Filament\Resources\Dalils\Pages;

use App\Filament\Resources\Dalils\DalilResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDalil extends EditRecord
{
    protected static string $resource = DalilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
