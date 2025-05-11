<?php

namespace App\CartFormatters;

class MachineryFormatter
{
    public static function format($cartItem): array
    {
        $machinery = $cartItem['item_type']::find($cartItem['item_id']);

        return [
            'id' => $machinery->id,
            'item_type' => $cartItem['item_type'],
            'model_no' => $machinery->title ?? null,
            'img' => asset('storage/' . ($machinery->thumbnail ?? 'default.png')),
            'description' => $machinery->description ?? '',
            'discount' => $cartItem['discount'] ?? 0,
            'amount' => $cartItem['amount'] ?? 0,
            'quantity' => $cartItem['quantity'] ?? 1,
            'extra' => $cartItem['extra'] ?? null,
            'url' => route('machine.show', $machinery->id),
        ];
    }
}
