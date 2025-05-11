<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Brand;
use App\Models\Machinery;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class MachineFilter extends Component
{
    use WithPagination;

    public $machineryBrands;
    public string|null $search= null;
    public array $selectedBrand = [];

    public int|null $selectedCategory = null;
    public int|null $selectedSubCategory = null;
    public int|null $selectedWorkingNature = null;

    public string|int $screenWidth = 0;

    public function mount($brand,$categories,$subCategories,$workingNature)
    {
        if ($brand) {
            $defaultBrandSelected = $this->machineryBrands->firstWhere('id', $brand);

            if ($defaultBrandSelected) {
                $this->selectedBrand[] = [
                    'id' => $defaultBrandSelected->id,
                    'value' => $defaultBrandSelected->name,
                ];
            }
        }
        $this->selectedCategory = $categories;
        $this->selectedSubCategory = $subCategories;
        $this->selectedWorkingNature = $workingNature;
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
        $machineries = $this->fetchMachineries();
        $paginateItemNumber = $this->getPaginationNumber();

        return view('livewire.machine-filter', [
            'machineries' => $machineries->paginate($paginateItemNumber), // Use pagination for efficiency
        ]);
    }

    private function fetchMachineries()
    {
        $query = Machinery::query()->where('published', true);

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

                $q->whereIn('machinery_brand_id', $selectedBrandId);
            }

            if($this->selectedCategory){
                $q->where('machinery_category_id', $this->selectedCategory);
            }

            if($this->selectedSubCategory){
                $q->where('machinery_sub_category_id', $this->selectedSubCategory);
            }

            if($this->selectedWorkingNature){
                $q->where('machinery_working_nature_id', $this->selectedWorkingNature);
            }
        });
        return $query;
    }
}
