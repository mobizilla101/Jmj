<?php

namespace App\Filament\Resources\MachineryBrandResource\Pages;

use App\Filament\Resources\MachineryBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMachineryBrands extends ListRecords
{
    protected static string $resource = MachineryBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
