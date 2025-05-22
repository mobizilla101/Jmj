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
use Livewire\WithFileUploads;

class RepairForm extends Component implements HasForms
{
    use InteractsWithForms;
    use WithFileUploads;

    public ?array $data = [];

    public Settings $record;

    public function mount(): void
    {
        $this->loadDataIntoForm();
        $this->form->fill($this->data);
    }

    private function loadDataIntoForm()
    {
        // Load existing setting if it exists
        $setting = Settings::where('key', 'repair_pdf')->first();
        $this->data = [
            'repair_pdf' => $setting ? $setting->value : null,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('repair_pdf')
                    ->label('Upload Repair PDF')
                    ->directory('repair-pdfs')
                    ->acceptedFileTypes(['application/pdf'])
                    ->downloadable()
                    ->disk('public')
                    ->maxSize(51200)
                    ->openable()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {

        $data = $this->form->getState();

        // Save or update the settings record
        Settings::updateOrCreate(
            ['key' => 'repair_pdf'],
            ['value' => $data['repair_pdf'] ?? null,'cast' => 'string']
        );

        Notification::make()
            ->title('Success')
            ->body('Repair PDF updated successfully.')
            ->success()
            ->send();
    }


    public function render(): View
    {
        return view('livewire.repair-form');
    }
}
