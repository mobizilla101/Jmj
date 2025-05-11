<?php

namespace App\CartFormatters;

class PartsFormatter
{
    public static function format($cartItem): array
    {
        $part = $cartItem['item_type']::find($cartItem['item_id']);

        return [
            'id' => $part->id,
            'item_type' => $cartItem['item_type'],
            'model_no' => $part->name ?? null,
            'img' => asset('storage/' . ($part->thumbnail ?? 'default.png')),
            'description' => $part->description ?? '',
            'discount' => $cartItem['discount'] ?? 0,
            'amount' => $cartItem['amount'] ?? 0,
            'quantity' => $cartItem['quantity'] ?? 1,
            'extra' => $cartItem['extra'] ?? null,
            'url' => route('parts.show', $part->id),
        ];
    }
}
