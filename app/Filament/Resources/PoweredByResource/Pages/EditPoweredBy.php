<?php

namespace App\Filament\Resources\PoweredByResource\Pages;

use App\Filament\Resources\PoweredByResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoweredBy extends EditRecord
{
    protected static string $resource = PoweredByResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
