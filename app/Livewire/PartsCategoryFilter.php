<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Parts;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PartsCategoryFilter extends Component
{
    use WithPagination;

    public $brands;
    public string|null $search = null;
    public array $selectedBrand = [];
    public int|null $selectedModelId = null;
    public int|null $selectedCategoryId = null;
    public string $selectedSearch = 'parts';

    public string|int $screenWidth = 0;

    public function mount($brand, $category, $model)
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
        $this->selectedCategoryId = $category;
        $this->selectedModelId = $model;
    }

    public function setScreenWidth(int $width)
    {
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

    public function removeBrand(int $id)
    {
        $this->selectedBrand = array_filter($this->selectedBrand, function ($i) use ($id) {
            return $i['id'] !== $id;
        });
        $this->updatedState();
    }

    public function resetFilters()
    {
        $this->selectedBrand = [];
        $this->search = null;
        $this->updatedState();
    }

    public function getPaginationNumber()
    {
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
        $parts = $this->fetchParts();
        $paginateItemNumber = $this->getPaginationNumber();

        return view('livewire.parts-category-filter', [
            'parts' => $parts->paginate($paginateItemNumber), // Use pagination for efficiency
        ]);
    }

    private function fetchParts()
    {
        $query = Parts::query()->where('parts.published', true);

        $query->where(function ($q) {

            if ($this->search) {
                if ($this->selectedSearch === 'parts') {
                    $q->where('name', 'like', '%' . $this->search . '%');
                }
                if ($this->selectedSearch === 'model') {
                    $q->whereHas('model', function ($q) {
                        $q->where('model_no', 'like', '%' . $this->search . '%');
                    });
                }
            }

            // Filter by selected brands
            if ($this->selectedCategoryId) {
                $q->where('parts_category_id', $this->selectedCategoryId);
            }

        });

        if (!empty($this->selectedBrand)) {
            $selectedBrandId = array_reduce($this->selectedBrand, function ($val, $dat) {
                $val[] = $dat['id'];
                return $val;
            }, []);
            $query->whereHas('model',fn($q)=>$q->whereIn('brand_id',$selectedBrandId));
            $query->join('models', 'parts.model_id', '=', 'models.id');
        }

        if ($this->selectedModelId) {
            $query->orderByRaw('CASE WHEN models.id = ? THEN 0 ELSE 1 END', [$this->selectedModelId]);
        }

        $query->orderBy('parts.name', 'desc');

        return $query->select('parts.id', 'parts.name', 'parts.thumbnail', 'parts.price', 'parts.discount','parts.description');
    }
}
