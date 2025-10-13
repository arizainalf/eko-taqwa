<?php

namespace App\Filament\Resources\JenisKaidahs\Pages;

use App\Filament\Resources\JenisKaidahs\JenisKaidahResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisKaidah extends EditRecord
{
    protected static string $resource = JenisKaidahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
