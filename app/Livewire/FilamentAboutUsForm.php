<?php

namespace App\Livewire;

use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class FilamentAboutUsForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->loadDataIntoForm();
        $this->form->fill($this->data);
    }

    private function loadDataIntoForm()
    {
        // Retrieve existing settings for the banners
        $settings = Settings::where('key', 'aboutus')->first();

        // Load existing banner data if it exists, otherwise let the form handle nulls
        $this->data = $settings ? $settings->value : [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information')->schema([
                    TinyEditor::make('description'),
                    FileUpload::make('Image')
                        ->image()
                        ->imageEditor()
                        ->directory('aboutus/image')
                ])
            ])
            ->statePath('data')
            ->model(Settings::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        try {
            $record = Settings::updateOrCreate(
                ['key' => 'aboutus'], // The condition to find or create the setting
                ['value' => $data]    // The data to update or create the setting with
            );;

            $record->value = $data;  // This will call the setValueAttribute method
            $record->save();         // Save the model
            Notification::make()
                ->success()
                ->body("Saved")
                ->send();
        } catch (\Exception $exception) {
            Notification::make()
                ->danger()
                ->body('Something went wrong: ' . $exception->getMessage())
                ->send();
        }
    }

    public function render(): View
    {
        return view('livewire.filament-about-us-form');
    }
}
