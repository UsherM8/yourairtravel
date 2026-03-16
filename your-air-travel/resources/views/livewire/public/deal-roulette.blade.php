<div class="max-w-4xl mx-auto my-16 p-8 bg-white rounded-3xl shadow-xl border border-gray-100 flex flex-col md:flex-row items-center gap-12"
     x-data="{
        spinning: false,
        showWinner: false,
        winner: null,
        currentRotation: 0,

        async spin() {
            if (this.spinning) return;

            // Controleer of er deals zijn (via de Livewire property)
            if (!@js($hasDeals)) {
                alert('Oeps! We hebben helaas geen deals gevonden rond deze datum. Probeer een andere!');
                return;
            }

            this.spinning = true;
            this.showWinner = false;

            // 1. Vraag de winnaar aan Livewire
            let result = await $wire.spinWheel();
            if(!result) return;

            this.winner = result;

            // 2. Bereken de hoek (8 partjes = 45 graden per partje)
            let sliceAngle = 45;
            let targetAngle = result.index * sliceAngle;

            // 3. Wiskunde magie: We laten hem 5 keer 360 graden draaien voor de spanning,
            // en trekken de hoek van de winnaar eraf zodat hij precies bovenaan stopt.
            let spins = 5 * 360;
            let newRotation = this.currentRotation + spins + (360 - targetAngle) - (this.currentRotation % 360);

            this.currentRotation = newRotation;

            // 4. Wacht tot de CSS animatie klaar is (4 seconden)
            setTimeout(() => {
                this.spinning = false;
                this.showWinner = true;
            }, 4000);
        }
     }">

    {{-- LINKER KANT: De Datumkiezer en Tekst --}}
    <div class="w-full md:w-1/2 text-center md:text-left">
        <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mb-4">Laat het Rad bepalen! 🎡</h2>
        <p class="text-gray-500 font-medium mb-6">Heb je een datum in gedachten, maar weet je niet wáár je heen wilt? Kies je vertrekdatum en slinger aan het rad.</p>

        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Wanneer wil je uiterlijk vertrekken?</label>
            {{-- Flatpickr datum input gekoppeld aan Livewire --}}
            <input type="text"
                   x-init="flatpickr($el, {dateFormat: 'Y-m-d', minDate: 'today'})"
                   wire:model.live="departureDate"
                   placeholder="Kies een datum..."
                   class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#2596be] focus:ring-[#2596be] font-semibold text-gray-700">
        </div>

        <button @click="spin()"
                :disabled="spinning || !@js($hasDeals)"
                :class="{'opacity-50 cursor-not-allowed': spinning || !@js($hasDeals), 'hover:bg-[#1a7a9e] hover:scale-105 transform shadow-lg': !spinning && @js($hasDeals)}"
                class="w-full bg-[#2596be] text-white font-black text-xl px-8 py-4 rounded-xl transition-all duration-300">
            <span x-text="spinning ? 'Aan het draaien... 😵‍💫' : 'Slinger het Rad! 🎰'"></span>
        </button>

        {{-- Winnende Resultaat Weergave --}}
        <div x-show="showWinner" x-transition.duration.500ms style="display: none;" class="mt-8 bg-green-50 border border-green-200 p-6 rounded-2xl text-center shadow-inner">
            <span class="text-sm font-bold text-green-600 uppercase tracking-widest mb-1 block">Je reist naar...</span>
            <span class="text-gray-900 font-black text-2xl mb-4 block" x-text="winner?.location"></span>
            <a :href="'/deal/' + winner?.id" class="inline-block bg-white text-green-700 font-bold border border-green-300 hover:bg-green-600 hover:text-white transition-colors px-6 py-2 rounded-lg">
                Bekijk de Deal &rarr;
            </a>
        </div>
    </div>

    {{-- RECHTER KANT: Het Fysieke Rad --}}
    <div class="w-full md:w-1/2 flex justify-center relative py-10 overflow-hidden">

        {{-- De Pijl (Wijzer) --}}
        <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-[20px] border-r-[20px] border-t-[35px] border-l-transparent border-r-transparent border-t-[#e5764b] z-20 drop-shadow-md"></div>

        {{-- Het Draaiende Wiel --}}
        <div class="relative w-72 h-72 lg:w-96 lg:h-96 rounded-full border-8 border-gray-800 shadow-2xl"
             :style="`transform: rotate(${currentRotation}deg); transition: transform 4s cubic-bezier(0.1, 0, 0.1, 1);`">

            {{-- De gekleurde partjes (conic-gradient, verschoven met -22.5deg zodat het midden precies onder de wijzer ligt bij 0 graden) --}}
            <div class="absolute inset-0 rounded-full"
                 style="background: conic-gradient(from -22.5deg, #f8fafc 0 45deg, #e0f2fe 45deg 90deg, #f8fafc 90deg 135deg, #e0f2fe 135deg 180deg, #f8fafc 180deg 225deg, #e0f2fe 225deg 270deg, #f8fafc 270deg 315deg, #e0f2fe 315deg 360deg);">
            </div>

            {{-- De Tekst op de partjes --}}
            @foreach($deals as $index => $deal)
                <div class="absolute top-0 left-1/2 w-12 h-[50%] origin-bottom -ml-6 flex justify-center pt-6 lg:pt-10 z-10"
                     style="transform: rotate({{ $index * 45 }}deg);">
                    <span class="text-xs lg:text-sm font-black text-gray-700 tracking-wider truncate overflow-hidden whitespace-nowrap h-24"
                          style="writing-mode: vertical-rl; text-orientation: mixed;">
                        {{ \Illuminate\Support\Str::limit($deal['city'], 12) }}
                    </span>
                </div>
            @endforeach

            {{-- Het zwarte dopje in het midden --}}
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-gray-800 rounded-full z-20 shadow-inner border-2 border-gray-600"></div>
        </div>
    </div>
</div>
