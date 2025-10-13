<?php

namespace App\Filament\Resources\Ayats\Pages;

use App\Filament\Resources\Ayats\AyatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAyat extends EditRecord
{
    protected static string $resource = AyatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
