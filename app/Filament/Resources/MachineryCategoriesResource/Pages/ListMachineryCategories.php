<?php

namespace App\Filament\Resources\MachineryCategoriesResource\Pages;

use App\Filament\Resources\MachineryCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMachineryCategories extends ListRecords
{
    protected static string $resource = MachineryCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
