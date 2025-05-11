<?php

namespace App\Filament\Resources\MachinerySubCategoryResource\Pages;

use App\Filament\Resources\MachinerySubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMachinerySubCategory extends EditRecord
{
    protected static string $resource = MachinerySubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
