<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YourAirTravel - De Beste Vluchten</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    {{-- GLOBALE HEADER --}}
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                {{-- 1. KLIKBAAR LOGO (Helemaal links) --}}
                <a href="/" class="flex-shrink-0 flex items-center group gap-3">
                    {{-- 📸 JOUW AFBEELDING LOGO --}}
                    <img src="{{ asset('images/logo.png') }}" alt="YourAirTravel Logo" class="h-16 w-auto group-hover:scale-105 transition-transform drop-shadow-sm">
                </a>

                {{-- 2. DESKTOP NAVIGATIE (Midden) --}}
                <div class="hidden lg:flex items-center space-x-8 text-sm font-bold text-gray-700 h-full">

                    {{-- A. Landen (Cascading Mega Menu) --}}
                    <div x-data="{ open: false }" @mouseleave="open = false" class="relative flex items-center h-full cursor-pointer">
                        <div @mouseover="open = true" class="flex items-center hover:text-[#2596be] transition-colors h-full">
                            Landen
                            <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                        {{-- Het Mega Menu dat uitklapt --}}
                        <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-20 left-1/2 -translate-x-1/2 w-[700px] bg-white border border-gray-100 shadow-2xl rounded-2xl p-8 grid grid-cols-3 gap-8 cursor-default">

                            {{-- Spanje kolom --}}
                            <div>
                                <h4 class="font-extrabold text-gray-900 mb-3 border-b-2 border-[#2596be]/30 pb-2 flex items-center">
                                    <span class="text-xl mr-2">🇪🇸</span> Spanje
                                </h4>
                                <ul class="space-y-2 text-gray-500 font-semibold">
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Alle Spanje Deals</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Barcelona</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Madrid</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Ibiza</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Mallorca</a></li>
                                </ul>
                            </div>

                            {{-- Italië kolom --}}
                            <div>
                                <h4 class="font-extrabold text-gray-900 mb-3 border-b-2 border-green-100 pb-2 flex items-center">
                                    <span class="text-xl mr-2">🇮🇹</span> Italië
                                </h4>
                                <ul class="space-y-2 text-gray-500 font-semibold">
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Alle Italië Deals</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Rome</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Milaan</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Venetië</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Sicilië</a></li>
                                </ul>
                            </div>

                            {{-- Griekenland / Rest kolom --}}
                            <div>
                                <h4 class="font-extrabold text-gray-900 mb-3 border-b-2 border-[#2596be]/30 pb-2 flex items-center">
                                    <span class="text-xl mr-2">🇬🇷</span> Griekenland
                                </h4>
                                <ul class="space-y-2 text-gray-500 font-semibold mb-6">
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Athene</a></li>
                                    <li><a href="#" class="hover:text-[#2596be] hover:translate-x-1 inline-block transition-transform">Kreta</a></li>
                                </ul>

                                {{-- Secundaire kleur (Oranje) bij hover --}}
                                <a href="#" class="text-[#2596be] hover:text-[#e5764b] font-black flex items-center group transition-colors">
                                    Bekijk alle landen
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- B. Vakanties (Dropdown met Tags) --}}
                    <div x-data="{ open: false }" @mouseleave="open = false" class="relative flex items-center h-full cursor-pointer">
                        <div @mouseover="open = true" class="flex items-center hover:text-[#2596be] transition-colors h-full">
                            Vakanties
                            <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                        <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-20 left-0 w-64 bg-white border border-gray-100 shadow-xl rounded-2xl py-3 cursor-default">
                            <a href="#" class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                <span class="bg-yellow-100 text-yellow-700 p-1.5 rounded-lg mr-3 group-hover:scale-110 transition-transform">☀️</span>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-[#2596be] transition-colors">Zonvakanties</div>
                                    <div class="text-xs text-gray-500 font-medium">Binnen & buiten Europa</div>
                                </div>
                            </a>
                            <a href="#" class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                <span class="bg-blue-100 text-blue-700 p-1.5 rounded-lg mr-3 group-hover:scale-110 transition-transform">🏛️</span>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-[#2596be] transition-colors">Stedentrips</div>
                                    <div class="text-xs text-gray-500 font-medium">Korte weekendjes weg</div>
                                </div>
                            </a>
                            <a href="#" class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                <span class="bg-green-100 text-green-700 p-1.5 rounded-lg mr-3 group-hover:scale-110 transition-transform">🌴</span>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-[#2596be] transition-colors">All-Inclusive</div>
                                    <div class="text-xs text-gray-500 font-medium">Zorgeloos genieten</div>
                                </div>
                            </a>
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <a href="#" class="flex items-center px-5 py-2 hover:bg-gray-50 transition-colors text-[#e5764b]">
                                    <span class="mr-2 font-black">⚡</span> Last-Minutes
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- C. Reisorganisaties (Simpele Dropdown) --}}
                    <div x-data="{ open: false }" @mouseleave="open = false" class="relative flex items-center h-full cursor-pointer">
                        <div @mouseover="open = true" class="flex items-center hover:text-[#2596be] transition-colors h-full">
                            Reisorganisaties
                            <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                        <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-20 left-0 w-48 bg-white border border-gray-100 shadow-xl rounded-2xl py-2 cursor-default">
                            <a href="#" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">TUI</a>
                            <a href="#" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">Corendon</a>
                            <a href="#" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">Sunweb</a>
                            <a href="#" class="block px-5 py-2 hover:bg-gray-50 hover:text-[#2596be] transition-colors">Prijsvrij</a>
                        </div>
                    </div>

                    {{-- D. Vliegtickets --}}
                    <a href="#" class="hover:text-[#2596be] transition-colors flex items-center h-full">Vliegtickets</a>

                    {{-- E. Blogs --}}
                    <a href="#" class="hover:text-[#2596be] transition-colors flex items-center h-full">Blogs</a>

                    {{-- F. Over Ons --}}
                    <a href="#" class="flex items-center h-full text-[#2596be] hover:text-[#e5764b] transition-colors group">
                        <svg class="w-4 h-4 mr-1.5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Over Ons
                    </a>
                </div>

                {{-- 3. RECHTER KANT (Dashboard / Inlog knop) --}}
                <div class="hidden lg:flex items-center space-x-4">
                    @auth
                        {{-- Dashboard knop in de nieuwe Oranje actiekleur! --}}
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-[#e5764b] hover:bg-[#d4653a] text-white font-bold rounded-xl transition-colors text-sm shadow-md hover:shadow-lg">
                            Mijn Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-[#2596be] transition-colors">Log in</a>
                    @endauth
                </div>

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
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Bestemmingen</a></li>
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Vakanties</a></li>
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Vliegtickets</a></li>
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Reisblog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Over Ons</h4>
                    <ul class="space-y-2 text-gray-500 font-medium text-sm">
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Over Ons</a></li>
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-[#2596be] transition-colors">Algemene Voorwaarden</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 text-center text-sm font-medium text-gray-400">
                &copy; {{ date('Y') }} YourAirTravel. Alle rechten voorbehouden.
            </div>
        </div>
    </footer>

</body>
</html>
