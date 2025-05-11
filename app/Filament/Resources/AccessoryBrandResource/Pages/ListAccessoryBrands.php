<?php

namespace App\Filament\Resources\AccessoryBrandResource\Pages;

use App\Filament\Resources\AccessoryBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccessoryBrands extends ListRecords
{
    protected static string $resource = AccessoryBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
