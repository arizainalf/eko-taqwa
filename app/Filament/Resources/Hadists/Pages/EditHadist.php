<?php

namespace App\Filament\Resources\Hadists\Pages;

use App\Filament\Resources\Hadists\HadistResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHadist extends EditRecord
{
    protected static string $resource = HadistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
