<?php

namespace App\Filament\Resources\SkuResource\Pages;

use App\Filament\Resources\SkuResource;
use App\Models\Sku;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSku extends CreateRecord
{
    protected static string $resource = SkuResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->ensureUniqueCombination($data);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->ensureUniqueCombination($data);
        return $data;
    }

    private function ensureUniqueCombination(array $data): void
    {
        $exists = Sku::where('model_id', $data['model_id'])
            ->where('storage', $data['storage'])
            ->where('memory', $data['memory'])
            ->exists();

        if ($exists) {

            Notification::make()
                ->title('Duplicate SKU')
                ->body('A SKU with this model, storage, and memory already exists.')
                ->danger()
                ->send();
            throw \Illuminate\Validation\ValidationException::withMessages([
                'model_id' => 'A SKU with this model, storage, and memory already exists.',
            ]);
        }
    }
}
