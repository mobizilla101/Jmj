<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enum\OrderStatus;
use App\Enum\PaymentStatus;
use App\Filament\Resources\OrderResource;
use App\Mail\InvoiceMail;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewOrders extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Complete Order')
                ->action(function($record){
                        $this->completeOrder($record);
                        Mail::to($record->user->email)->send(new InvoiceMail($record));
                    })
                ->hidden(function ($record) {
                    if ($record->orderStatus === OrderStatus::COMPLETED) {
                        return true;
                    }
                    if ($record->payment_details()->where('status', '!=', PaymentStatus::COMPLETED)->exists()) {
                        return true;
                    }
                    $a = (int)$record->payment_details()->where('status', PaymentStatus::COMPLETED)->sum('amount');
                    $b = ($record->total + $record->transportation_cost);
//                    dd(["wew"=>$a,"EWWE"=>$b]);
//                    dd((int)$record->payment_details()->where('status', PaymentStatus::COMPLETED)->sum('amount') !== ($record->total + $record->transportation_cost));
                    if ((int)$record->payment_details()->where('status', PaymentStatus::COMPLETED)->sum('amount') !== ($record->total + $record->transportation_cost)) {
                        return true;
                    }
                    return false;
                }
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
