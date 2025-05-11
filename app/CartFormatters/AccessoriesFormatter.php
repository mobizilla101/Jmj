<?php

namespace App\CartFormatters;

class AccessoriesFormatter
{
    public static function format($cartItem): array
    {
        $accessories = $cartItem['item_type']::find($cartItem['item_id']);

        return [
            'id' => $accessories->id,
            'item_type' => $cartItem['item_type'],
            'model_no' => $accessories->title ?? null,
            'img' => asset('storage/' . ($accessories->thumbnail ?? 'default.png')),
            'description' => $accessories->description ?? '',
            'discount' => $cartItem['discount'] ?? 0,
            'amount' => $cartItem['amount'] ?? 0,
            'quantity' => $cartItem['quantity'] ?? 1,
            'extra' => $cartItem['extra'] ?? null,
            'url' => route('accessories.show', $accessories->slug),
        ];
    }
}
