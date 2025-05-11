<?php

namespace App\Filament\Resources\MachineryBrandResource\Pages;

use App\Filament\Resources\MachineryBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMachineryBrand extends EditRecord
{
    protected static string $resource = MachineryBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
