<?php

namespace App\Filament\Resources\Kaidahs\Pages;

use App\Filament\Resources\Kaidahs\KaidahResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKaidah extends EditRecord
{
    protected static string $resource = KaidahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
