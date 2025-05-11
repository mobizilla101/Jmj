<?php

namespace App\CartFormatters;

class SecondhandInventoriesFormatter
{
    public static function format($cartItem): array
    {
        $secondhandInventory = $cartItem['item_type']::find($cartItem['item_id']);

        return [
            'id' => $secondhandInventory->id,
            'item_type' => $cartItem['item_type'],
            'model_no' => $secondhandInventory->sku->model->model_no ?? null,
            'img' => asset('storage/' . ($secondhandInventory->thumbnail ?? 'default.png')),
            'description' => $secondhandInventory->description ?? '',
            'color' => $secondhandInventory->color->where('id', $cartItem['extra']['color_id'] ?? null)->first(),
            'discount' => $secondhandInventory->discount ?? 0,
            'refurbed' => $secondhandInventory->refurb,
            'amount' => $secondhandInventory->amount ?? 0,
            'storage' => $secondhandInventory->sku->storage ?? '',
            'memory' => $secondhandInventory->memory ?? '',
            'quantity' => $cartItem['quantity'] ?? 1,
            'extra' => $cartItem['extra'] ?? null,
            'url' => $secondhandInventory->refurbed?route('refurb.show',$secondhandInventory->id):route('used.show', $secondhandInventory->id),
        ];
    }
}
