<?php

namespace App\Filament\Resources\SecondhandInventoryResource\Pages;

use App\Filament\Resources\SecondhandInventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSecondhandInventory extends EditRecord
{
    protected static string $resource = SecondhandInventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
