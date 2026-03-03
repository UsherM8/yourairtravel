@php
    // --- 1. PRIJS LOGICA ---
    $normalePrijs = floatval($deal->price ?? 0);
    $kortingsPrijs = floatval($deal->discounted_price ?? 0);
    $hasDiscount = ($kortingsPrijs > 0 && $kortingsPrijs < $normalePrijs);
    $currentPrice = $hasDiscount ? $kortingsPrijs : $normalePrijs;

    // --- 2. DYNAMISCH GRID PATROON ---
    $idx = $index ?? 0;
    if (isset($isHomepage) && $isHomepage) {
        $sizeClass = match($idx % 4) {
            0 => 'md:col-span-2 lg:col-span-2 h-[300px]',
            1 => 'md:col-span-1 lg:col-span-1 h-[300px]',
            2 => 'md:col-span-1 lg:col-span-1 h-[300px]',
            3 => 'md:col-span-2 lg:col-span-2 h-[300px]',
            default => 'col-span-1 h-[300px]'
        };
    } else {
        $sizeClass = match($idx % 6) {
            0 => 'md:col-span-2 lg:col-span-2 lg:row-span-2 h-[350px] lg:h-[500px]',
            1 => 'md:col-span-1 lg:col-span-1 h-[250px]',
            2 => 'md:col-span-1 lg:col-span-1 h-[250px]',
            3 => 'md:col-span-1 lg:col-span-1 h-[250px] lg:h-[300px]',
            4 => 'md:col-span-1 lg:col-span-2 h-[250px] lg:h-[300px]',
            5 => 'md:col-span-2 lg:col-span-3 h-[250px] lg:h-[350px]',
            default => 'md:col-span-1 lg:col-span-1 h-[250px]'
        };
    }

    // --- 3. ANIMATIE LOGICA ---
    $delay = ($idx % 6) * 150;
    $directions = ['translate-y-8 opacity-0', 'scale-95 opacity-0', '-translate-x-8 opacity-0', 'translate-x-8 opacity-0'];
    $startAnimation = $directions[$idx % 4];

    // --- 4. HOSTINGER AFBEELDING ROUTING FIX ---
    // We bepalen hier één keer het juiste pad
    $rawPath = null;
    if(isset($deal->primaryImage)) {
        $rawPath = $deal->primaryImage->path;
    } elseif(!empty($deal->image_path)) {
        $rawPath = $deal->image_path;
    } elseif(isset($deal->images) && count($deal->images) > 0) {
        $rawPath = $deal->images[0]->path ?? $deal->images[0]->image_path;
    }

    $finalImageUrl = null;
    if ($rawPath) {
        // Check of hij in de nieuwe uploads map staat, anders fallback naar storage
        $finalImageUrl = file_exists(public_path('uploads/' . $rawPath))
            ? asset('uploads/' . $rawPath)
            : asset('storage/' . $rawPath);
    }
@endphp

<div x-data="{ show: false }"
     x-init="setTimeout(() => show = true, {{ $delay }})"
     x-show="show"
     x-transition:enter="transition-all ease-out duration-1000"
     x-transition:enter-start="{{ $startAnimation }}"
     x-transition:enter-end="translate-x-0 translate-y-0 scale-100 opacity-100"
     style="display: none;"
     class="{{ $sizeClass }} relative rounded-3xl overflow-hidden shadow-md hover:shadow-2xl hover:scale-[1.02] transition-all duration-500 group block">

    {{-- Algemene onzichtbare link over de hele foto --}}
    <a href="{{ route('public.deal.show', $deal->id) }}" wire:navigate class="absolute inset-0 z-30">
        <span class="sr-only">Bekijk details van {{ $deal->title }}</span>
    </a>

    {{-- DE VOLLEDIGE AFBEELDING --}}
    @if($finalImageUrl)
        <img src="{{ $finalImageUrl }}" alt="{{ $deal->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s] ease-in-out">
    @else
        <div class="absolute inset-0 w-full h-full bg-gray-800 flex items-center justify-center text-gray-500 font-bold italic">
            ✈️ YourAirTravel
        </div>
    @endif

    {{-- Subtielere donkere overloop --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/5 to-transparent z-10 pointer-events-none"></div>

    {{-- Korting Badge --}}
    @if($hasDiscount && $normalePrijs > 0)
        <div class="absolute top-4 right-4 z-20 bg-[#e5764b] text-white text-xs font-black px-3 py-1.5 rounded-xl shadow-lg transform rotate-2">
            -{{ round((($normalePrijs - $kortingsPrijs) / $normalePrijs) * 100) }}%
        </div>
    @endif

    {{-- CONTENT --}}
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-5 z-20 flex flex-col justify-end pointer-events-none">
        <div class="flex flex-col gap-2">
            {{-- Prijs --}}
            <div class="inline-flex items-baseline self-start gap-1.5 bg-black/40 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/10 shadow-xl">
                <span class="text-[10px] text-white/80 font-bold uppercase tracking-wider">Vanaf</span>
                <span class="text-xl md:text-2xl font-black text-[#2596be] drop-shadow-md">€{{ $currentPrice }}</span>
                @if($hasDiscount)
                    <span class="text-xs text-white/50 line-through font-medium ml-1">€{{ $normalePrijs }}</span>
                @endif
            </div>
            {{-- Titel --}}
            <h3 class="text-lg md:text-xl font-bold text-white leading-snug drop-shadow-md line-clamp-2">
                {{ $deal->title }}
            </h3>
        </div>
    </div>
</div>
