<?php

namespace App\CartFormatters;

class SkuFormatter
{
    public static function format($cartItem): array
    {
        $sku = $cartItem['item_type']::find($cartItem['item_id']);

        return [
            'id' => $sku->id,
            'item_type' => $cartItem['item_type'],
            'model_no' => $sku->model->model_no ?? null,
            'img' => asset('storage/' . ($sku->model->thumbnail ?? 'default.png')),
            'description' => $sku->model->description ?? '',
            'color' => $sku->color->where('id', $cartItem['extra']['color_id'] ?? null)->first(),
            'discount' => $cartItem['discount'] ?? 0,
            'amount' => $cartItem['amount'] ?? 0,
            'storage' => $sku->storage ?? '',
            'memory' => $sku->memory ?? '',
            'quantity' => $cartItem['quantity'] ?? 1,
            'extra' => $cartItem['extra'] ?? null,
            'url'=> route('product.show',$sku->model->slug),
        ];
    }
}
