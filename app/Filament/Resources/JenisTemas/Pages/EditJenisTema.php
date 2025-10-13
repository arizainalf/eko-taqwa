<?php

namespace App\Filament\Resources\JenisTemas\Pages;

use App\Filament\Resources\JenisTemas\JenisTemaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisTema extends EditRecord
{
    protected static string $resource = JenisTemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
