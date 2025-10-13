<?php

namespace App\Filament\Resources\Cps\Pages;

use App\Filament\Resources\Cps\CpResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCp extends EditRecord
{
    protected static string $resource = CpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
