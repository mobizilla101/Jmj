<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Sku;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Concerns\HasTabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CartManager extends Component
{

    public Collection|\Illuminate\Support\Collection|null $carts = null;
    public int $subTotal = 0;
    public int $transportationCost = 50;
    public int $total = 0;


    public function mount()
    {
        $this->carts = Cart::getCartItems();
        $this->reloadCalculation($this->carts);
    }

    public function reloadCalculation($carts)
    {
        $this->subTotal = $carts->sum(fn ($cart) => $cart['quantity'] * ($cart['amount'] - ($cart['discount']/100)));
        $this->total = $this->subTotal + $this->transportationCost;
    }

    public function increaseQuantity($itemType, $itemId)
    {
        Cart::increaseQuantity($itemType, $itemId);
        $carts = Cart::getCartItems();
        $this->reloadCalculation($carts);
        return $carts; // Send back updated cart
    }

    public function decreaseQuantity($itemType, $itemId)
    {
        Cart::decreaseQuantity($itemType, $itemId);
        $carts = Cart::getCartItems();
        $this->reloadCalculation($carts);
        return $carts; // Send back updated cart
    }

    public function removeItem($itemType, $itemId)
    {
        Cart::removeItem($itemType, $itemId);
        $carts = Cart::getCartItems();
        $this->reloadCalculation($carts);
        return $carts; // Send back updated cart
    }

    public function render()
    {
        return view('livewire.cart-manager', [
                'carts' => $this->carts,
                'subTotal' => $this->subTotal,
                'total' => $this->total,
            ]
        );
    }
}
