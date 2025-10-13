<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKitab extends EditRecord
{
    protected static string $resource = KitabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
