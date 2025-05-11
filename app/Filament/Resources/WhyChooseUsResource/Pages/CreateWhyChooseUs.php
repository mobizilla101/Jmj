<?php

namespace App\Filament\Resources\WhyChooseUsResource\Pages;

use App\Filament\Resources\WhyChooseUsResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Models\WhyChooseUs;

class CreateWhyChooseUs extends CreateRecord
{
    protected static string $resource = WhyChooseUsResource::class;

    protected static ?string $model = WhyChooseUs::class;


    protected function beforeCreate(): void
    {
        if (\App\Models\WhyChooseUs::count() >= 4) {
            Notification::make()
                ->warning()
                ->title('You cannot create more then 4 records')
                ->body('Delete old record to create new one.')
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}
