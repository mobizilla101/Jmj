<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\SecondhandInventory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RefurbFilter extends Component
{
    use WithPagination;

    public $brands;
    public string|null $search= null;
    public array $selectedBrand = [];
    public array $selectedStorage = [];
    public array $selectedRam = [];

    public string|int $screenWidth = 0;

    public function mount($brand)
    {
        if ($brand) {
            $defaultBrandSelected = $this->brands->firstWhere('id', $brand);

            if ($defaultBrandSelected) {
                $this->selectedBrand[] = [
                    'id' => $defaultBrandSelected->id,
                    'value' => $defaultBrandSelected->name,
                ];
            }
        }
    }

    public function setScreenWidth(int $width){
        $this->screenWidth = $width;
    }

    public function updatedState()
    {
        $this->resetPage();
    }

    public function updateBrand(int $id, string $value)
    {
        foreach ($this->selectedBrand as $brand) {
            if ($brand['id'] === $id && $brand['value'] === $value) {
            return; // Already exists, no update needed.
            }
        }

    $this->selectedBrand[] = [
        'id' => $id,
        'value' => $value
    ];

    $this->updatedState(); // Handle post-update logic.
    }


    public function removeBrand(int $id){
        $this->selectedBrand = array_filter($this->selectedBrand, function($i) use ($id){
            return $i['id'] !== $id;
        });
        $this->updatedState();
    }

    public function updateStorage(int $value){
        if(in_array($value,$this->selectedStorage)){
            $this->selectedStorage = array_filter($this->selectedStorage,function($val) use ($value){
                return $val !== $value;
            });
        }else{
            $this->selectedStorage[] = $value;
        }
        $this->updatedState();
    }

    public function updateRam(int $value){
        if(in_array($value,$this->selectedRam)){
            $this->selectedRam = array_filter($this->selectedRam,function($val) use ($value){
                return $val !== $value;
            });
        }else{
            $this->selectedRam[] = $value;
        }
        $this->updatedState();
    }

    public function resetFilters(){
        $this->selectedBrand = [];
        $this->selectedStorage = [];
        $this->selectedRam = [];
        $this->search = null;
        $this->updatedState();
    }

    public function getPaginationNumber() {
        $width = $this->screenWidth;
        return match (true) {
            $width >= 1280 => 15, // xl and above
            $width >= 1024 => 12, // lg
            $width >= 768 => 9,  // md
            default => 10,        // below md
        };
    }

    public function render()
    {
        $secondhandInventories = $this->fetchSecondhandInventory();
        $paginateItemNumber = $this->getPaginationNumber();

        return view('livewire.refurb-filter', [
            'secondhandInventories' => $secondhandInventories->paginate($paginateItemNumber), // Use pagination for efficiency
        ]);
    }

    private function fetchSecondhandInventory()
    {
        $query = SecondhandInventory::query()->where('refurbed',true);

        $query->where(function ($q) {

            if($this->search){
                $q->whereHas('sku.model', function ($subQuery) {
                    $subQuery->where('model_no', 'like', '%' . $this->search . '%');
                });
            }

            // Filter by selected brands
            if (!empty($this->selectedBrand)) {
                $selectedBrandId = array_reduce($this->selectedBrand,function($val,$dat){
                    $val[] = $dat['id'];
                    return $val;
                },[]);

                $q->whereHas('sku.model',function($subQuery) use ($selectedBrandId){
                    $subQuery->whereIn('brand_id', $selectedBrandId);
                });
            }

            // Filter by selected storage
            if (!empty($this->selectedStorage)) {
                $q->whereHas('sku', function ($subQuery) {
                    $subQuery->whereIn('storage', $this->selectedStorage);
                });
            }

            // Filter by selected RAM
            if (!empty($this->selectedRam)) {
                $q->whereHas('sku', function ($subQuery) {
                    $subQuery->whereIn('memory', $this->selectedRam);
                });
            }
        });
        return $query;
    }
}
