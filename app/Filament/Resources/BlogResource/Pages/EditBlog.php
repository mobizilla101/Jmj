<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('published')
                ->color(function ($record) {
                    return $record->published ? 'danger' : 'success';
                })
                ->label(function ($record) {
                    return $record->published ? 'Un-Publish' : 'Publish';
                })
                ->button()
                ->requiresConfirmation()
                ->action(function ($record) {
                    try {
                        if ($record) {
                            $record->published = !$record?->published;
                            $record->save();

                            $responseMessage = $record->published ? "Published the Model Successfully" : "Un-Publish the Model Successfully";

                            Notification::make()
                                ->title($responseMessage)
                                ->success()
                                ->send();
                        }
                    } catch (\Exception $exception) {
                        Notification::make()
                            ->title($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                })
            ,
            Actions\Action::make('preview')
                ->label('Preview')
                ->url(fn($record) => route('blog.preview', $record->slug))
                ->openUrlInNewTab()
                ->hidden(fn($record) => $record->published ?? false)
            ,
            Actions\DeleteAction::make(),
        ];
    }
}
