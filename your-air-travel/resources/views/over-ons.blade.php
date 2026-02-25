@component('layouts.public')

    <div class="bg-white">
        {{-- Hero Sectie --}}
        <div class="relative py-24 bg-gradient-to-r from-[#2596be] to-[#1a7a9e] overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Het Verhaal Achter YourAirTravel</h1>
                <p class="text-xl text-blue-50 max-w-2xl mx-auto">Wij geloven dat geweldige reizen niet duur hoeven te zijn. Wij zoeken de pareltjes, zodat jij alleen nog maar hoeft te pakken.</p>
            </div>
            {{-- Decoratieve cirkel --}}
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Missie & Visie --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 mb-6 uppercase tracking-tight">Onze Missie</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Bij YourAirTravel draait alles om de kunst van het vinden. Elke dag scannen we honderden aanbiedingen, van last-minute zonvakanties tot verre vliegreizen, om alleen de allerbeste deals op ons platform te plaatsen.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        We zijn geen reisbureau, maar jouw persoonlijke navigator in de complexe wereld van online reizen. We verbinden je direct met de scherpste deals van vertrouwde partners.
                    </p>
                </div>
                <div class="relative">

                    {{-- HIER IS HET LOGO BLOK AANGEPAST --}}
                    <div class="aspect-video bg-white rounded-3xl overflow-hidden shadow-2xl rotate-2 p-8 flex items-center justify-center border border-gray-100">
                        <img src="{{ asset('images/logo.png') }}" alt="YourAirTravel Logo" class="w-full h-full object-contain hover:scale-105 transition-transform duration-500">
                    </div>
                    {{-- EINDE AANPASSING --}}

                    <div class="absolute -bottom-6 -left-6 bg-orange-500 text-white p-8 rounded-2xl shadow-xl -rotate-3 hidden md:block">
                        <p class="text-2xl font-black">100%</p>
                        <p class="font-bold">Passie voor reizen</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Waarom YourAirTravel? --}}
        <div class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Waarom YourAirTravel?</h2>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 transition-transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Gecureerde Deals</h3>
                    <p class="text-gray-500 font-medium">Geen spam, alleen de deals die we zelf ook zouden boeken.</p>
                </div>

                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 transition-transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-blue-100 text-[#2596be] rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Flash Sneltreinen</h3>
                    <p class="text-gray-500 font-medium">Dankzij onze Instant Deals ben je altijd als eerste bij de scherpste prijzen.</p>
                </div>

                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 transition-transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 20.944a11.955 11.955 0 01-8.618-3.04A11.952 11.952 0 0012 20.056z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Transparantie</h3>
                    <p class="text-gray-500 font-medium">We zijn eerlijk over prijzen en beschikbaarheid. Geen verrassingen achteraf.</p>
                </div>
            </div>
        </div>

        {{-- Call to Action --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <h2 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-tight">Klaar om te vertrekken?</h2>
            <a href="/" class="inline-block bg-[#2596be] text-white px-10 py-4 rounded-full font-black text-lg shadow-lg hover:bg-[#1a7a9e] transition-all transform hover:scale-105">
                BEKIJK DE DEALS VAN VANDAAG
            </a>
        </div>
    </div>

@endcomponent
