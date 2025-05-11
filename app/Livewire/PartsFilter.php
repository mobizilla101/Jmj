<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PartsFilter extends Component
{
    use WithPagination;

    public $brands;
    public string|null $search= null;
    public array $selectedBrand = [];
    public bool $showModal = false;
    public int|null $selectedModelId = null;

    public string|int $screenWidth = 0;

    public array $parts = [];

    public function __construct()
    {
        $this->parts = [
            ['url' => asset('assets/images/parts/popup-image.png')],
            ['url' => asset('assets/images/parts/housing.png')],
            ['url' => asset('assets/images/parts/charging-flex.png')],
            ['url' => asset('assets/images/parts/antenna.png')],
            ['url' => asset('assets/images/parts/wireless-charging-flex.png')],
            ['url' => asset('assets/images/parts/front-camera.png')],
            ['url' => asset('assets/images/parts/sim-holder.png')],
            ['url' => asset('assets/images/parts/ear-speaker.png')],
            ['url' => asset('assets/images/parts/power.png')],
            ['url' => asset('assets/images/parts/main-speaker.png')],
            ['url' => asset('assets/images/parts/main-camera.png')],
            ['url' => asset('assets/images/parts/vibrator.png')],
            ['url' => asset('assets/images/parts/battery.png')],
            ['url' => asset('assets/images/parts/mic.png')],
            ['url' => asset('assets/images/parts/sim-tray.png')],
        ];
    }

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

    public function resetFilters(){
        $this->selectedBrand = [];
        $this->search = null;
        $this->updatedState();
    }

    public function selectModel(int $modelId){
        $this->selectedModelId = $modelId;
        $this->showModal = true;
    }

    public function deselectModel(){
        $this->showModal = false;
        $this->selectedModelId = null;
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
        $models = $this->fetchModels();
        $paginateItemNumber = $this->getPaginationNumber();

        return view('livewire.parts-filter', [
            'models' => $models->paginate($paginateItemNumber), // Use pagination for efficiency
        ]);
    }

    private function fetchModels()
    {
        $query = Model::query()->where('published',true);

        $query->where(function ($q) {

            if($this->search){
                $q->where('model_no','like','%'.$this->search.'%');
            }

            // Filter by selected brands
            if (!empty($this->selectedBrand)) {
                $selectedBrandId = array_reduce($this->selectedBrand,function($val,$dat){
                    $val[] = $dat['id'];
                    return $val;
                },[]);

                $q->whereIn('brand_id', $selectedBrandId);
            }
        });
        return $query;
    }
}
