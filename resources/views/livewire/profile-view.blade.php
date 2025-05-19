<div>
    <form wire:submit="save">
        <div class="flex items-center justify-center mb-4">
            {{ $this->form }}
        </div>

        <section class="rounded-md shadow-xl bg-white px-8 py-6 max-w-2xl mx-auto">

{{--            show flash message here--}}

            <h3 class="text-2xl font-bold text-blue-400 mb-4">User Details</h3>
            <div class="space-y-2 mb-5">
                <div class="flex sm:flex-row justify-between items-center flex-wrap">
                    <span class="text-lg font-semibold text-primary-300">Name:</span>
                    <span class="text-lg text-primary-300">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex justify-between items-center flex-wrap">
                    <span class="text-lg font-semibold text-primary-300">Username:</span>
                    <span class="text-lg text-primary-300">{{ auth()->user()->username }}</span>
                </div>
                <div class="flex justify-between items-baseline flex-wrap">
                    <span class="text-lg font-semibold text-primary-300">Email:</span>
                    <span class="text-lg text-primary-300 max-w-32 break-words">{{ auth()->user()->email }}</span>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-blue-400 mb-4">Address</h3>
            <div class="space-y-2 mb-5">
                <div class="flex justify-between items-center flex-wrap">
                    <span class="text-lg font-semibold text-primary-300">Address:</span>
                    @if ($this->address)
                        <div class="flex items-center space-x-4">
                            <span class="text-lg text-primary-300">{{ auth()->user()->address }}</span>
                            <button wire:click="set('address','')">Change</button>
                        </div>
                    @else
                        <input type="text" wire:model="address" class="w-full border rounded p-2 text-lg" placeholder="Enter address">
                    @endif
                </div>
            </div>

            <h3 class="text-2xl font-bold text-blue-400 mb-4">Contact Details</h3>
            <div class="space-y-2 mb-5">
                <div class="flex justify-between items-center flex-wrap">
                    <span class="text-lg font-semibold text-primary-300">Phone number:</span>
                    @if ($this->phone)
                        <div class="flex items-center space-x-4">
                            <span class="text-lg text-primary-300">{{ auth()->user()->phone }}</span>
                            <button wire:click="set('phone','')">Change</button>
                        </div>
                    @else
                        <input type="text" wire:model="phone" class="w-full border rounded p-2 text-lg" placeholder="Enter phone number">
                    @endif
                </div>
            </div>
            <button class="bg-green-400 text-white px-4 py-2 mt-4 rounded" type="submit">
                Submit
            </button>
        </section>
    </form>

    <x-filament-actions::modals />
</div>
