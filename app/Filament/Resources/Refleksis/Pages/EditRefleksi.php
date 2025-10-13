<?php

namespace App\Filament\Resources\Refleksis\Pages;

use App\Filament\Resources\Refleksis\RefleksiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRefleksi extends EditRecord
{
    protected static string $resource = RefleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
