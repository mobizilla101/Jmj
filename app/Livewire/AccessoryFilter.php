<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AccessoryBrand;
use App\Models\Accessory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AccessoryFilter extends Component
{
    use WithPagination;

    public $brands;
    public string|null $search= null;
    public array $selectedBrand = [];

    public int|null $selectedCategory = null;
    public int|null $selectedSubCategory = null;

    public string|int $screenWidth = 0;

    public function mount($brand,$categories,$subCategory)
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
        $this->selectedCategory = $categories;
        $this->selectedSubCategory = $subCategory;
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

    public function resetFilters(){
        $this->selectedBrand = [];
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
        $accessories = $this->fetchAccessories();
        $paginateItemNumber = $this->getPaginationNumber();

        return view('livewire.accessory-filter', [
            'accessories' => $accessories->paginate($paginateItemNumber), // Use pagination for efficiency
        ]);
    }

    private function fetchAccessories()
    {
        $query = Accessory::query()->where('published', true);

        $query->where(function ($q) {

            if($this->search){
                $q->where('title','like','%'.$this->search.'%');
            }

            // Filter by selected brands
            if (!empty($this->selectedBrand)) {
                $selectedBrandId = array_reduce($this->selectedBrand,function($val,$dat){
                    $val[] = $dat['id'];
                    return $val;
                },[]);

                $q->whereIn('brand_id', $selectedBrandId);
            }

            if($this->selectedCategory){
                $q->where('category_id', $this->selectedCategory);
            }

            if($this->selectedSubCategory){
                $q->where('sub_category_id',$this->selectedSubCategory);
            }

        });
        return $query;
    }
}
