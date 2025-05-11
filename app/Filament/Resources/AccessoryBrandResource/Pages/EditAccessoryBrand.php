<?php

namespace App\Filament\Resources\AccessoryBrandResource\Pages;

use App\Filament\Resources\AccessoryBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessoryBrand extends EditRecord
{
    protected static string $resource = AccessoryBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
