<?php

namespace App\Filament\Resources\MachineryWorkingNatureResource\Pages;

use App\Filament\Resources\MachineryWorkingNatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMachineryWorkingNature extends EditRecord
{
    protected static string $resource = MachineryWorkingNatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
