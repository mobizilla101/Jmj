<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentDetails;
use App\PaymentMethod\PaymentGateway;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $transportationCost = 50;
    public function index()
    {
        $cartItems = Cart::getCartItems();
        $subTotal = $cartItems->sum(fn ($cart) => $cart['quantity'] * ($cart['amount'] - ($cart['discount']/100)));
        $transportationCost = $this->transportationCost;
        $total =    $subTotal + $this->transportationCost;
        return view('ecom.checkout.index',compact('cartItems','subTotal','total','transportationCost'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);


        $cartItems = Cart::getCartItems();

        $subTotal = $cartItems->sum(function ($cart){
    $discountedPrice = $cart['amount'] * (1 - ($cart['discount'] / 100));
        $discountedPrice = max(0, $discountedPrice);
        return $cart['quantity'] * $discountedPrice;
    });
        $total =    $subTotal + $this->transportationCost;

        $order = Order::create([
            'transportation_cost' => $this->transportationCost,
            'total' => $subTotal,
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'user_id'=> auth()->user()->id
        ]);

        foreach ($cartItems as $cartItem) {
            $order->order_details()->create([
                'item_id'=>$cartItem['id'],
                'item_type'=>$cartItem['item_type'],
                'quantity' => $cartItem['quantity'],
                'amount' => $cartItem['amount'],
                'extra' => $cartItem['extra'] ?? null,
                'discount' => $cartItem['discount'] ?? 0,
            ]);
        }

        // Handle payment details and process payment
        $paymentGatway = new PaymentGateway($order,$total,$validatedData['payment_method']);

        $paymentGatway->process();

        Cart::clear();

        return redirect()->route('auth.profile.orders.view',$order->id);
    }

    public function cancel()
    {
        return redirect()->route('cart');
    }
}
