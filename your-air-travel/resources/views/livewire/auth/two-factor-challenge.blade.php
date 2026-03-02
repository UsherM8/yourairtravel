<div>
    <div class="mb-6 text-center">
        @if($setupMode)
            <h2 class="text-2xl font-black text-gray-900 mb-2">Beveilig je account 📱</h2>
            <p class="text-gray-600 text-sm">Scan de onderstaande QR-code met je Authenticator App (bijv. Google of Microsoft Authenticator) en vul de 6-cijferige code in om 2FA definitief te activeren.</p>

            <div class="my-6 flex justify-center">
                <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-200 inline-block">
                    {!! $qrCodeSvg !!}
                </div>
            </div>
        @else
            <h2 class="text-2xl font-black text-gray-900 mb-2">Two-Factor Authentication 🔒</h2>
            <p class="text-gray-600 text-sm">Open je Authenticator App en vul de 6-cijferige code in om door te gaan naar het dashboard.</p>
        @endif
    </div>

    <form wire:submit="verify">
        <div>
            <x-input-label for="code" value="Authenticatie Code" class="text-center w-full block" />

            {{-- Het invulveld is speciaal vormgegeven voor een 6-cijferige code --}}
            <x-text-input wire:model="code" id="code"
                          class="block mt-2 w-full text-center text-3xl tracking-[0.5em] font-mono py-3 focus:border-[#2596be] focus:ring-[#2596be]"
                          type="text"
                          inputmode="numeric"
                          autofocus
                          autocomplete="one-time-code"
                          placeholder="••••••"
                          maxlength="6" />

            <div class="text-center">
                <x-input-error :messages="$errors->get('code')" class="mt-3" />
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="bg-[#2596be] hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors w-full flex justify-center items-center shadow-md active:scale-95">
                <span wire:loading.remove>
                    {{ $setupMode ? 'Activeren & Inloggen' : 'Verifiëren & Inloggen' }}
                </span>
                <span wire:loading>Bezig met controleren...</span>
            </button>
        </div>
    </form>
</div>
