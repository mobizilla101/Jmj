<?php

namespace App\Filament\Resources\AccessoryResource\Pages;

use App\Filament\Resources\AccessoryResource;
use App\Models\Accessory;
use App\Models\AccessoryBrand;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JetBrains\PhpStorm\NoReturn;

class EditAccessory extends EditRecord
{
    protected static string $resource = AccessoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
