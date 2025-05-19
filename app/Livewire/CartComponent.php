<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;

class CartComponent extends Component
{
    public $count = 0;
    protected $listeners = ['cartUpdated' => 'pollCartCount'];
    public function mount()
    {
        $this->count = count(Cart::getCartItems());
    }

    public function pollCartCount()
    {
        $this->count = count(Cart::getCartItems());
    }

    public function render()
    {
        return view('livewire.cart-component');
    }
}
