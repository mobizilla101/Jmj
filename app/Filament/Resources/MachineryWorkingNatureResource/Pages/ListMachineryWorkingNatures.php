<?php

namespace App\Filament\Resources\MachineryWorkingNatureResource\Pages;

use App\Filament\Resources\MachineryWorkingNatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMachineryWorkingNatures extends ListRecords
{
    protected static string $resource = MachineryWorkingNatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
