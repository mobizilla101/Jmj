<?php

namespace App\Filament\Resources\PartsCategoryResource\Pages;

use App\Filament\Resources\PartsCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartsCategory extends EditRecord
{
    protected static string $resource = PartsCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
