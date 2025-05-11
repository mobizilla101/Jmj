<?php

namespace App\Livewire;

use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class FilamentAppSettings extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->loadDataIntoForm();
        $this->form->fill($this->data); // Fill the form with existing data
    }

    private function loadDataIntoForm()
    {
        // Retrieve existing settings for the banners
        $settings = Settings::where('key', 'banners')->first();

        // Load existing banner data if it exists, otherwise let the form handle nulls
        $this->data = $settings ? $settings->value : [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Banners')->schema([
                    Forms\Components\Fieldset::make('First Slider')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\FileUpload::make('first_banner')
                            ->label('Desktop')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->directory('banner'),
                        Forms\Components\FileUpload::make('first_mobile_banner')
                            ->label('Mobile')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->directory('banner')
                    ])
                    ])
                    ,
                    Forms\Components\Fieldset::make('Second Slider')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\FileUpload::make('second_banner')
                            ->label('Desktop')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->directory('banner'),
                        Forms\Components\FileUpload::make('second_mobile_banner')
                            ->label('Mobile')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->directory('banner')

                    ])
                        ])
                    ,
                    Forms\Components\Fieldset::make('Third Slider')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\FileUpload::make('third_banner')
                            ->label('Desktop')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->directory('banner'),
                        Forms\Components\FileUpload::make('third_mobile_banner')
                            ->label('Mobile')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->directory('banner')
                    ])
                        ])
                ])->collapsible()
            ])
            ->statePath('data')
            ->model(Settings ::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        //Adding data to the settings for the banners only
        $bannerData = $this->bannerDataFilter($data);
        try{
            $this->createBannerData($bannerData);
        }catch(\Exception $exception){
            Notification::make()
                ->danger()
                ->body('Something went wrong: '.$exception->getMessage())
                ->send();
        }

    }

    private function createBannerData($data)
    {
        $setting = Settings::updateOrCreate(
            ['key' => 'banners'], // The condition to find or create the setting
            ['value' => $data]    // The data to update or create the setting with
        );

        // Manually trigger the mutator for the 'value' field
        $setting->value = $data;  // This will call the setValueAttribute method
        $setting->save();         // Save the model
    }

    private function bannerDataFilter($data): array
    {
        $fields = [
            "first_banner",
            "first_mobile_banner",
            "second_banner",
            "second_mobile_banner",
            "third_banner",
            "third_mobile_banner"
        ];
        return array_filter($data, function ($key) use ($fields) {
            return in_array($key, $fields);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function render(): View
    {
        return view('livewire.filament-app-settings');
    }
}
