<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sku;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('ecom.cart.index');
    }

    public function store(Request $request,Sku $sku){
        Cart::addItem([
            'id'=>$sku->id,
            'item_type'=>$sku->getMorphClass(),
            'amount'=>$sku->price,
            'discount' => $sku->discount,
            'quantity' => (int) $request->quantity ?? 1,
            'extra' => []
        ]);

        return back()->with(
            'success',"Cart Item created"
        );
    }

    public function clear()
    {
        // Clear all cart items for the logged-in user
        Cart::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Cart cleared.');
    }
}
