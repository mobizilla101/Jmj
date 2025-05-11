<?php

namespace App\Filament\Resources\PartsResource\Pages;

use App\Filament\Resources\PartsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParts extends EditRecord
{
    protected static string $resource = PartsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
