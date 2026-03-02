<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border border-gray-100">

            <div class="mb-8 border-b border-gray-100 pb-4">
                <h2 class="text-2xl font-black text-gray-900">Nieuwe Gebruiker Uitnodigen 🧑‍💻</h2>
                <p class="text-gray-500 mt-1">Ze ontvangen een e-mail met een tijdelijk wachtwoord en een link die 24 uur geldig is.</p>
            </div>

            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg font-bold">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="createUser" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700">Naam</label>
                    <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-[#2596be] focus:ring-[#2596be]">
                    @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">E-mailadres</label>
                    <input type="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-[#2596be] focus:ring-[#2596be]">
                    @error('email') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_admin" class="rounded border-gray-300 text-[#2596be] shadow-sm focus:ring-[#2596be] h-5 w-5">
                        <span class="ml-3">
                            <span class="block text-sm font-bold text-gray-900">Maak deze persoon Beheerder (Super Admin)</span>
                            <span class="block text-xs text-gray-500">Admins kunnen gebruikers aanmaken en verwijderen. Normale accounts kunnen alleen content beheren.</span>
                        </span>
                    </label>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" wire:loading.attr="disabled" class="bg-[#2596be] hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition-all active:scale-95 flex items-center">
                        <span wire:loading.remove>Uitnodiging Versturen</span>
                        <span wire:loading>Bezig met verzenden...</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
