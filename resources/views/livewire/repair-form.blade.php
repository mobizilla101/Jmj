<div>
    <form wire:submit="create">
        <div class="mb-4">
            {{ $this->form }}
        </div>
        <x-filament::button type="submit" wire:loading.attr="disabled">
            <span wire:loading.remove>Submit</span>
            <span wire:loading>Saving...</span> <!-- Show "Saving..." when form is submitting -->
        </x-filament::button>
    </form>

    <x-filament-actions::modals />
</div>
