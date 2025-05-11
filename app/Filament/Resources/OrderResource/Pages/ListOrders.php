<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enum\OrderStatus;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    public function getTabs(): array
    {
        return [
            'Processing' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('orderStatus', OrderStatus::PROCESSING))
            ,
            'Completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('orderStatus', OrderStatus::COMPLETED)),
            'all' => Tab::make(),
        ];
    }
}
