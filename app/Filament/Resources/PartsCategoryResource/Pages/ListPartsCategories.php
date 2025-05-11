<?php

namespace App\Filament\Resources\PartsCategoryResource\Pages;

use App\Filament\Resources\PartsCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartsCategories extends ListRecords
{
    protected static string $resource = PartsCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
