<div>
    <div class="mb-4 text-sm text-gray-600">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Welkom, {{ $user->name }}! 🎉</h2>
        <p>Stel hieronder je wachtwoord in om je account te activeren en toegang te krijgen tot het dashboard.</p>
    </div>

    <form wire:submit="savePassword">
        <div class="mt-4">
            <x-input-label for="password" value="Nieuw Wachtwoord" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full border-gray-300 focus:border-[#2596be] focus:ring-[#2596be]"
                            type="password" required autofocus />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Bevestig Wachtwoord" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-[#2596be] focus:ring-[#2596be]"
                            type="password" required />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="bg-[#2596be] hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors w-full flex justify-center items-center">
                <span wire:loading.remove>Opslaan & Inloggen</span>
                <span wire:loading>Bezig...</span>
            </button>
        </div>
    </form>
</div>
