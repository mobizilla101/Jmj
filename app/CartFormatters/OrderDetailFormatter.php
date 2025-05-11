<?php

namespace App\CartFormatters;

use App\Models\Accessory;
use App\Models\Machinery;
use App\Models\Parts;
use App\Models\SecondhandInventory;
use App\Models\Sku;

class OrderDetailFormatter
{
    public static function format($orderDetail): array
    {
        $formatter = self::getFormatter($orderDetail->item_type);

        return $formatter ? $formatter::format($orderDetail) : [];
    }

    protected static function getFormatter(string $itemType): ?string
    {
        return [
            Sku::class => SkuFormatter::class,
            Machinery::class => MachineryFormatter::class,
            Accessory::class => AccessoriesFormatter::class,
            Parts::class => PartsFormatter::class,
            SecondhandInventory::class => SecondhandInventoriesFormatter::class,
        ][$itemType] ?? null;
    }

}
