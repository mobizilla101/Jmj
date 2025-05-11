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

    public function store(Sku $sku){
        Cart::create([
            'user_id'=>auth()->user()->id,
            'sku_id'=>$sku->id
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
