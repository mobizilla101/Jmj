<?php

namespace App\Filament\Resources\MachinerySubCategoryResource\Pages;

use App\Filament\Resources\MachinerySubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMachinerySubCategories extends ListRecords
{
    protected static string $resource = MachinerySubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
