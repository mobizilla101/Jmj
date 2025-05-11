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
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class FaqForm extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];

    public function mount(): void
    {
        $faq = Settings::where('key', 'faq')->first();
        $this->data = [
            'faq' => $faq ? $faq->value : '', // Pre-fill the form with the existing FAQ content or empty string
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make('faq')
                ->schema([
                    Forms\Components\TextInput::make('question')
                    ->required(),
                    Forms\Components\Textarea::make('answer')
                    ->required()
                ])
            ])
            ->statePath('data')
            ->model(Settings::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        // Use updateOrCreate to either update or create the record
        Settings::updateOrCreate(
            ['key' => 'faq'], // Find the record with 'faq' key
            ['value' => $data['faq']] // Update or set the 'value'
        );

        // Show a success notification
        Notification::make()
            ->title('Success!')
            ->body('FAQ content has been saved successfully.')
            ->success()  // This specifies a success notification
            ->send();
    }

    public function render(): View
    {
        return view('livewire.faq-form');
    }
}
