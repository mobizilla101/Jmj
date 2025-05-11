<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enum\OrderStatus;
use App\Enum\PaymentStatus;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewOrders extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Complete Order')
                ->action(fn($record) => $this->completeOrder($record))
                ->hidden(fn($record) =>
                    $record->orderStatus === OrderStatus::COMPLETED ||
                    abs(($record->transportation_cost + $record->total) -
                        $record->payment_details()
                            ->where('status', PaymentStatus::COMPLETED)
                            ->get()
                            ->sum('amount')) > 0.01
                ),
        ];
    }

    protected function completeOrder($record): void
    {
        $paymentTotal = $record->payment_details()
            ->where('status', PaymentStatus::COMPLETED)
            ->get()
            ->sum('amount');

        $expectedTotal = $record->total + $record->transportation_cost;

        if (abs($paymentTotal - $expectedTotal) > 0.01) {
            Notification::make()
                ->title('Payment Mismatch')
                ->body('The payment amount and order amount should match.')
                ->danger()
                ->send();
            return;
        }

        $record->update([
            'orderStatus' => OrderStatus::COMPLETED,
        ]);

        Notification::make()
            ->title('Order Completed')
            ->success()
            ->send();
    }
}
