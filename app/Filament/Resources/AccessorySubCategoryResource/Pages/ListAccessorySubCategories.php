<?php

namespace App\Filament\Resources\AccessorySubCategoryResource\Pages;

use App\Filament\Resources\AccessorySubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccessorySubCategories extends ListRecords
{
    protected static string $resource = AccessorySubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
