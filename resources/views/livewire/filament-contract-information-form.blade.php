<div>

    <form wire:submit="create">
        <div class="mb-4">
        {{ $this->form }}
        </div>
            <x-filament::button type="submit">
                Submit
            </x-filament::button>

    </form>

    <x-filament-actions::modals />
</div>
