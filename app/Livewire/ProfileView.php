<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;

class ProfileView extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public User $record;

    public string $address = '';
    public string $phone = '';

    public function mount(): void
    {
        // Automatically load the authenticated user
        $this->record = Auth::user();
        $this->form->fill($this->record->toArray());

        // Populate address and phone fields
        $this->address = $this->record->address ?? '';
        $this->phone = $this->record->phone ?? '';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
//                FileUpload::make('avatar')
//                    ->label('')
//                    ->directory('avatar')
//                    ->avatar()
//                    ->image()
//                ->live()
//                ->afterStateUpdated(function($path){
//                    dd($path);
//                })

            ])
            ->model($this->record) // Bind form to automatically loaded User model
            ->statePath('data');
    }

    public function save()
    {
        // Update user details
            $this->record->address = $this->address;
            $this->record->phone = $this->phone;
            $this->record->save();

        session()->flash('profile_message', 'Profile updated successfully!');
        return redirect()->route('auth.profile');
    }

    public function render(): View
    {
        return view('livewire.profile-view');
    }
}
