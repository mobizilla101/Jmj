<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;

class CartComponent extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $cartItems = Cart::getCartItems();
        $this->count = count($cartItems);
    }

    public function render()
    {
        return view('livewire.cart-component');
    }
}
