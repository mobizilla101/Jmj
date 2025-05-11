<?php

namespace App\Filament\Resources\YoutubeVideoListResource\Pages;

use App\Filament\Resources\YoutubeVideoListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYoutubeVideoList extends EditRecord
{
    protected static string $resource = YoutubeVideoListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
