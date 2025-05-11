<?php

namespace App\Filament\Resources\YoutubeVideoListResource\Pages;

use App\Filament\Resources\YoutubeVideoListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYoutubeVideoLists extends ListRecords
{
    protected static string $resource = YoutubeVideoListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
