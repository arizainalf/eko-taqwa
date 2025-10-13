<?php

namespace App\Filament\Resources\HasilKuis\Pages;

use App\Filament\Resources\HasilKuis\HasilKuisResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHasilKuis extends EditRecord
{
    protected static string $resource = HasilKuisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
