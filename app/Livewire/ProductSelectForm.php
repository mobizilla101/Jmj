<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class ProductSelectForm extends Component
{
    public $product;
    public array $colors = [];
    public array $storages = [];
    public array $rams = [];

    public int|null $selectedColorId = null;
    public int|null $selectedStorage = null;
    public int|null $selectedRam = null;

    public bool $alreadyInCart = false;

    public bool $hasItem = false;
    public int|null $subTotal = null;
    public int|null $total = null;
    public int|null $discount = null;

    public Sku|null $selectedSku = null;

    public string $whatsAppMessage = "";


    public function mount($filters,$product){

        $this->product = $product;
        $this->colors = $product->skus()
            ->whereHas('color')
            ->get()
            ->pluck('color')
            ->flatten()
            ->unique('id')
            ->toArray()
        ;

        $this->storages = $product->skus()->pluck('storage')->unique()
            ->toArray();
        $this->rams = $product->skus()->pluck('memory')
            ->unique()
        ->toArray();

        $lowestPriceSku = $product->skus()
            ->whereHas('color')
            ->orderBy('price', 'asc')
            ->first();


        if (!$filters && $lowestPriceSku) {
            $this->selectedColorId = $lowestPriceSku->color()->first()->id;
            $this->selectedStorage = $lowestPriceSku->storage;
            $this->selectedRam = $lowestPriceSku->memory;
        }

        if($filters){
            $this->selectedColorId = $filters['color'];
            $this->selectedStorage = $filters['storage'];
            $this->selectedRam = $filters['memory'];
        }

        $this->eveluation();
    }

    public function getColors(){
        return json_encode($this->colors);
    }

    public function selectColor(int $color){
        if($this->selectedColorId === $color) return;
        $this->selectedColorId = $color;
        $this->eveluation();
    }

    public function selectStorage(int $storage){
        if($this->selectedStorage === $storage) return;
        $this->selectedStorage = $storage;
        $this->eveluation();
    }

    public function selectRam(int $ram){
        if($this->selectedRam === $ram) return;
        $this->selectedRam = $ram;
        $this->eveluation();
    }

    public function eveluation(){
        if(!$this->selectedStorage || !$this->selectedRam || !$this->selectedColorId)
        {
            $this->resetPrice();
            return ;
        }

        $temp = $this->product
            ->skus()
            ->where('memory',$this->selectedRam)
            ->where('storage',$this->selectedStorage)
            ->whereHas('color',function($query){
                $query->where('colors.id',$this->selectedColorId);
            })
            ->first();

        if(!$temp){
            $this->hasItem = false;
            $this->resetPrice();
            return;
        }

        $this->hasItem = true;

        $this->selectedSku = $temp;

        $this->alreadyInCart = Cart::hasInCart($temp,[
                'color_id'=>$this->selectedColorId
            ]);

        $this->subTotal = $temp->price;
        $this->discount = $temp->discount;
        $this->total = $this->discount > 0 ? ($temp->price - ($temp->price * ($temp->discount) /100)):$this->subTotal;
        $this->whatsAppMessage = urlencode("Hi,I am intrested in your product\n".route('product.show',$this->product).'?color='.$this->selectedColorId.'&storage='.$this->selectedStorage.'&ram='.$this->selectedRam
        );
    }

    public function resetPrice(){
        $this->total = $this->subTotal =  $this->discount = null;
    }

    public function addToCart(){
        if (!$this->selectedSku) {
            session()->flash('error', 'Please select all options before adding to cart.');
            return;
        }

        // Assuming `Cart::addItem` handles stock validation and addition
        Cart::addItem([
            'id'=>$this->selectedSku->id,
            'item_type'=>$this->selectedSku::class,
            'extra' => [
                'color_id'=>$this->selectedColorId,
            ],
            'discount'=>$this->discount,
            'amount'=>$this->subTotal,
            'quantity'=>1,
        ]);

        $this->alreadyInCart = true;

        $this->dispatch('cartUpdated');

        session()->flash('success', 'Item added to cart!');
    }
    public function render()
    {
        return view('livewire.product-select-form');
    }
}
