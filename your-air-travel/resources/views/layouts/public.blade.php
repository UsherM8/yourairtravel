<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YourAirTravel - De Beste Vluchten</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    {{-- 1. EERST JOUW EIGEN CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 2. DAARNA FLATPICKR --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

    {{-- Aangepaste scrollbar voor het nieuwe Mega Menu --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    {{-- GLOBALE HEADER --}}
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                {{-- 1. KLIKBAAR LOGO --}}
                <a href="/" class="flex-shrink-0 flex items-center group gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="YourAirTravel Logo" class="h-16 w-auto group-hover:scale-105 transition-transform drop-shadow-sm">
                </a>

                {{-- 2. DESKTOP NAVIGATIE --}}
                <div class="hidden lg:flex items-center space-x-8 text-sm font-bold text-gray-700 h-full">

                 {{-- a1. Blogs (NU WERKEND) --}}
                    <a href="{{ route('search.results', ['vakantietypes' => ['lastminute']]) }}" class="hover:text-[#2596be] transition-colors flex items-center h-full">
                    <span class="mr-2 font-black"></span> Last Minutes</a>

                    {{-- A. Landen (HET NIEUWE DOORZOEKBARE MEGA MENU!) --}}
                    <div x-data="countrySearchMenu()" @mouseleave="open = false; search = ''" class="relative flex items-center h-full cursor-pointer">
                        <div @mouseover="open = true" class="flex items-center hover:text-[#2596be] transition-colors h-full">
                            Landen
                            <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                        {{-- Het Uitklapvenster --}}
                        <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-20 left-1/2 -translate-x-1/2 w-[850px] bg-white border border-gray-100 shadow-2xl rounded-2xl overflow-hidden cursor-default flex flex-col max-h-[75vh]">

                            {{-- De Zoekbalk Binnenin het menu --}}
                            <div class="p-5 bg-gray-50 border-b border-gray-100">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <input x-model="search" type="text" placeholder="Zoek een land of stad... (bijv. Bali of Spanje)" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm text-gray-700 font-medium">
                                </div>
                            </div>

                            {{-- De Resultaten (Scrollbaar) --}}
                            <div class="p-8 overflow-y-auto custom-scrollbar flex-grow">

                                {{-- NIEUW: De "Toon alle deals" knop bovenaan! --}}
                                <div class="mb-8" x-show="search === ''">
                                    <a href="{{ route('search.results') }}" class="flex items-center justify-center w-full py-3 bg-[#2596be]/10 text-[#2596be] hover:bg-[#2596be] hover:text-white font-bold rounded-xl transition-all duration-300 group shadow-sm hover:shadow-md">
                                        <span class="text-lg mr-2 group-hover:scale-110 transition-transform">🌍</span>
                                        Bekijk alle bestemmingen & deals
                                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                                    <template x-for="item in filteredDestinations" :key="item.country">
                                        <div>
                                            {{-- Land Titel Link --}}
                                            <a :href="'/zoeken?landen[]=' + encodeURIComponent(item.country)" class="flex items-center group mb-3 border-b-2 border-[#2596be]/20 pb-2">
                                                <span class="text-xl mr-2" x-text="item.icon"></span>
                                                <h4 class="font-extrabold text-gray-900 group-hover:text-[#2596be] transition-colors" x-text="item.country"></h4>
                                            </a>
                                            {{-- Steden Lijst --}}
                                            <ul class="space-y-2 text-gray-500 font-semibold text-sm">
                                                <template x-if="item.cities.length > 0">
                                                    <li>
                                                        <a :href="'/zoeken?landen[]=' + encodeURIComponent(item.country)" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform text-[#2596be] opacity-80 hover:opacity-100">→ Alle deals</a>
                                                    </li>
                                                </template>
                                                <template x-for="city in item.filteredCities" :key="city">
                                                    <li>
                                                        <a :href="'/zoeken?steden[]=' + encodeURIComponent(city)" class="hover:text-[#e5764b] hover:translate-x-1 inline-block transition-transform" x-text="city"></a>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </template>
                                </div>

                                {{-- Melding als er niks gevonden is --}}
                                <div x-show="filteredDestinations.length === 0" class="text-center py-10">
                                    <div class="text-4xl mb-3">🕵️‍♂️</div>
                                    <h3 class="text-lg font-bold text-gray-900">Geen bestemmingen gevonden</h3>
                                    <p class="text-gray-500">Probeer een andere zoekterm.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- B. Vakanties --}}
                    <div x-data="{ open: false }" @mouseleave="open = false" class="relative flex items-center h-full cursor-pointer">
                        <div @mouseover="open = true" class="flex items-center hover:text-[#2596be] transition-colors h-full">
                            Vakanties
                            <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                        <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-20 left-0 w-64 bg-white border border-gray-100 shadow-xl rounded-2xl py-3 cursor-default">
                            <a href="{{ route('search.results', ['vakantietypes' => ['zon']]) }}" class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                <span class="bg-yellow-100 text-yellow-700 p-1.5 rounded-lg mr-3 group-hover:scale-110 transition-transform">☀️</span>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-[#2596be] transition-colors">Zonvakanties</div>
                                    <div class="text-xs text-gray-500 font-medium">Binnen & buiten Europa</div>
                                </div>
                            </a>
                            <a href="{{ route('search.results', ['vakantietypes' => ['stad']]) }}" class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                <span class="bg-blue-100 text-blue-700 p-1.5 rounded-lg mr-3 group-hover:scale-110 transition-transform">🏛️</span>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-[#2596be] transition-colors">Stedentrips</div>
                                    <div class="text-xs text-gray-500 font-medium">Korte weekendjes weg</div>
                                </div>
                            </a>
                            <a href="{{ route('search.results', ['vakantietypes' => ['natuur']]) }}" class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                <span class="bg-green-100 text-green-700 p-1.5 rounded-lg mr-3 group-hover:scale-110 transition-transform">🌴</span>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-[#2596be] transition-colors">Natuur & Actief</div>
                                    <div class="text-xs text-gray-500 font-medium">Verken de wereld</div>
                                </div>
                            </a>
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <a href="{{ route('search.results', ['vakantietypes' => ['lastminute']]) }}" class="flex items-center px-5 py-2 hover:bg-gray-50 transition-colors text-[#e5764b]">
                                    <span class="mr-2 font-black">⚡</span> Last-Minutes
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- C. Reisorganisaties --}}
                    <div x-data="{ open: false }" @mouseleave="open = false" class="relative flex items-center h-full cursor-pointer">
                        <div @mouseover="open = true" class="flex items-center hover:text-[#2596be] transition-colors h-full">
                            Reisorganisaties
                            <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                        <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-20 left-0 w-48 bg-white border border-gray-100 shadow-xl rounded-2xl py-2 cursor-default">
                            <a href="{{ route('search.results') }}" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">TUI</a>
                            <a href="{{ route('search.results') }}" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">Corendon</a>
                            <a href="{{ route('search.results') }}" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">Sunweb</a>
                            <a href="{{ route('search.results') }}" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">Prijsvrij</a>
                        </div>
                    </div>

                    {{-- D. Vliegtickets --}}
                    <a href="{{ route('search.results') }}" class="hover:text-[#2596be] transition-colors flex items-center h-full">Vliegtickets</a>

                    {{-- E. Blogs (NU WERKEND) --}}
                    <a href="{{ route('public.blogs') }}" class="hover:text-[#2596be] transition-colors flex items-center h-full">Blogs</a>

                    {{-- F. Over Ons (AANGEPAST) --}}
                    <a href="{{ route('over-ons') }}" class="flex items-center h-full text-[#2596be] hover:text-[#e5764b] transition-colors group">
                        <svg class="w-4 h-4 mr-1.5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Over Ons
                    </a>
                </div>
                <div> </div>

            </div>
        </div>
    </nav>

    {{-- CONTENT VAN DE PAGINA'S --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- GLOBALE FOOTER --}}
    <footer class="bg-white border-t border-gray-200 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <span class="text-2xl font-black text-[#2596be] tracking-tighter mb-4 block">YourAirTravel✈️</span>
                    <p class="text-gray-500 font-medium max-w-sm">Wij speuren het internet af naar de beste fouttarieven, last-minutes en verborgen vluchtaanbiedingen. Zo betaal jij nooit meer te veel voor je vakantie.</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Snel naar</h4>
                    <ul class="space-y-2 text-gray-500 font-medium text-sm">
                        <li><a href="{{ route('search.results') }}" class="hover:text-[#2596be] transition-colors">Bestemmingen</a></li>
                        <li><a href="{{ route('search.results') }}" class="hover:text-[#2596be] transition-colors">Vakanties</a></li>
                        <li><a href="{{ route('search.results') }}" class="hover:text-[#2596be] transition-colors">Vliegtickets</a></li>
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Reisblog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Over Ons</h4>
                    <ul class="space-y-2 text-gray-500 font-medium text-sm">
                        {{-- AANGEPAST --}}
                        <li><a href="{{ route('over-ons') }}" class="hover:text-[#2596be] transition-colors">Over Ons</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#2596be] transition-colors">Contact</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-[#2596be] transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('voorwaarden') }}" class="hover:text-[#2596be] transition-colors">Algemene Voorwaarden</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 text-center text-sm font-medium text-gray-400">
                &copy; {{ date('Y') }} YourAirTravel. Alle rechten voorbehouden.
            </div>
        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/nl.min.js"></script>

    {{-- HET JAVASCRIPT BREIN VAN HET LANDEN MEGA MENU --}}
    <script>
        function countrySearchMenu() {
            return {
                open: false,
                search: '',
                // Hier kun je in de toekomst eindeloos veel landen en steden aan toevoegen!
                destinations: [
                    // --- EUROPA ---
                    { country: 'Europa (Alle deals)', icon: '🌍', cities: [] },
                    { country: 'Spanje', icon: '🇪🇸', cities: ['Barcelona', 'Madrid', 'Valencia', 'Ibiza', 'Mallorca', 'Malaga', 'Canarische Eilanden'] },
                    { country: 'Italië', icon: '🇮🇹', cities: ['Rome', 'Milaan', 'Venetië', 'Napels', 'Sicilië'] },
                    { country: 'Griekenland', icon: '🇬🇷', cities: ['Athene', 'Kreta', 'Santorini', 'Rhodos', 'Kos'] },
                    { country: 'Portugal', icon: '🇵🇹', cities: ['Lissabon', 'Porto', 'Faro (Algarve)', 'Madeira'] },
                    { country: 'Turkije', icon: '🇹🇷', cities: ['Istanbul', 'Antalya', 'Bodrum', 'Alanya'] },
                    { country: 'Nederland', icon: '🇳🇱', cities: ['Amsterdam', 'Rotterdam', 'Maastricht', 'Texel'] },

                    // --- CARAÏBEN ---
                    { country: 'ABC-Eilanden', icon: '🏝️', cities: ['Aruba', 'Bonaire', 'Curaçao'] },

                    // --- AFRIKA & MIDDEN-OOSTEN ---
                    { country: 'Afrika (Alle deals)', icon: '🌍', cities: [] },
                    { country: 'Egypte', icon: '🇪🇬', cities: ['Hurghada', 'Sharm el-Sheikh', 'Caïro'] },
                    { country: 'Marokko', icon: '🇲🇦', cities: ['Marrakech', 'Agadir', 'Casablanca'] },
                    { country: 'Kaapverdië', icon: '🇨🇻', cities: ['Sal', 'Boa Vista', 'São Vicente'] },
                    { country: 'Senegal', icon: '🇸🇳', cities: ['Dakar'] },
                    { country: 'Kenia', icon: '🇰🇪', cities: ['Nairobi', 'Mombasa'] },
                    { country: 'Zuid-Afrika', icon: '🇿🇦', cities: ['Kaapstad', 'Johannesburg', 'Krugerpark'] },
                    { country: 'Ver. Arabische Emiraten', icon: '🇦🇪', cities: ['Dubai', 'Abu Dhabi'] },

                    // --- AZIË ---
                    { country: 'Azië (Alle deals)', icon: '🌏', cities: [] },
                    { country: 'Indonesië', icon: '🇮🇩', cities: ['Bali', 'Jakarta', 'Lombok'] },
                    { country: 'Thailand', icon: '🇹🇭', cities: ['Bangkok', 'Phuket', 'Koh Samui'] },
                    { country: 'Vietnam', icon: '🇻🇳', cities: ['Hanoi', 'Ho Chi Minhstad'] },
                    { country: 'Japan', icon: '🇯🇵', cities: ['Tokio', 'Kyoto', 'Osaka'] },
                    { country: 'China', icon: '🇨🇳', cities: ['Beijing', 'Shanghai'] }
                ],
                get filteredDestinations() {
                    // Als er niks is getypt, laat dan gewoon alle landen met hun steden zien
                    if (this.search === '') {
                        return this.destinations.map(d => ({ ...d, filteredCities: d.cities }));
                    }

                    // Filter de lijst als de bezoeker wel iets typt
                    const q = this.search.toLowerCase();
                    return this.destinations.map(d => {
                        const countryMatches = d.country.toLowerCase().includes(q);
                        const filteredCities = d.cities.filter(c => c.toLowerCase().includes(q));
                        return {
                            ...d,
                            filteredCities,
                            matches: countryMatches || filteredCities.length > 0
                        };
                    }).filter(d => d.matches);
                }
            }
        }
    </script>
</body>
</html>
