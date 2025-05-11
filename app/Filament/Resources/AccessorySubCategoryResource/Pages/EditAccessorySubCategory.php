<?php

namespace App\Filament\Resources\AccessorySubCategoryResource\Pages;

use App\Filament\Resources\AccessorySubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessorySubCategory extends EditRecord
{
    protected static string $resource = AccessorySubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
