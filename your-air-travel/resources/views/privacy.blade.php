@component('layouts.public')

    <div class="bg-gray-50 min-h-screen pb-20">
        {{-- Hero Sectie --}}
        <div class="relative py-20 bg-gradient-to-r from-[#2596be] to-[#1a7a9e] overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Privacy Policy</h1>
                <p class="text-lg text-blue-50">Hoe wij omgaan met jouw gegevens en privacy.</p>
                <p class="text-sm text-blue-200 mt-4">Laatst gewijzigd: {{ date('d-m-Y') }}</p>
            </div>
            {{-- Decoratieve cirkel --}}
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Content Sectie --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sm:p-12">

                <div class="space-y-8 text-gray-600 leading-relaxed">

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">1. Inleiding</h2>
                        <p>
                            Welkom bij YourAirTravel. Wij respecteren jouw privacy en dragen er zorg voor dat de persoonlijke informatie die je ons verschaft vertrouwelijk wordt behandeld. In deze privacy policy leggen we uit welke gegevens we verzamelen, waarom we dat doen en wat jouw rechten zijn.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">2. Gegevens die wij verzamelen</h2>
                        <p class="mb-3">Wanneer je onze website gebruikt, kunnen wij de volgende gegevens verzamelen:</p>
                        <ul class="list-disc pl-5 space-y-2">
                            <li><strong>Contactgegevens:</strong> Zoals je naam en e-mailadres wanneer je ons contactformulier invult of je aanmeldt voor de nieuwsbrief.</li>
                            <li><strong>Gebruiksgegevens:</strong> Informatie over hoe je onze website gebruikt, zoals je IP-adres, browsertype, bezochte pagina's en de tijd die je op onze website doorbrengt (via cookies en analytics).</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">3. Hoe we jouw gegevens gebruiken</h2>
                        <p class="mb-3">We gebruiken jouw gegevens voor de volgende doeleinden:</p>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Om je vragen te beantwoorden wanneer je contact met ons opneemt.</li>
                            <li>Om de website te verbeteren en te analyseren welke reisaanbiedingen het meest populair zijn.</li>
                            <li>Om je (indien je daarvoor toestemming hebt gegeven) onze nieuwsbrief met de nieuwste reisdeals te sturen.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">4. Affiliate links & Derden</h2>
                        <p>
                            YourAirTravel is een platform dat reisaanbiedingen verzamelt. Wij werken met zogenaamde affiliate links. Wanneer je op een deal klikt, word je doorverwezen naar de website van onze partner (zoals TUI, Corendon, etc.). Vanaf dat moment is het privacybeleid van de betreffende partner van toepassing. Wij delen geen persoonlijke gegevens van jou met deze partners, tenzij dit strikt noodzakelijk is.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">5. Cookies</h2>
                        <p>
                            Wij maken gebruik van cookies om de website goed te laten werken en om het gebruik van de website te analyseren. Je kunt je browser zo instellen dat je geen cookies meer ontvangt. In dat geval kunnen we echter niet garanderen dat alle diensten en functionaliteiten van de website op een juiste manier werken.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">6. Jouw Rechten</h2>
                        <p class="mb-3">Onder de Algemene Verordening Gegevensbescherming (AVG) heb je diverse rechten:</p>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Recht op inzage in jouw persoonsgegevens.</li>
                            <li>Recht op rectificatie (aanpassing) van onjuiste gegevens.</li>
                            <li>Recht om vergeten te worden (verwijdering van gegevens).</li>
                        </ul>
                        <p class="mt-4">
                            Wil je gebruik maken van een van deze rechten? Neem dan contact met ons op via onderstaande gegevens.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">7. Contact</h2>
                        <p>
                            Heb je vragen over ons privacybeleid? Neem dan gerust contact met ons op:
                        </p>
                        <div class="mt-4 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <p class="font-bold text-gray-900">YourAirTravel</p>
                            <p>E-mail: <a href="mailto:info@yourairtravel.nl" class="text-[#2596be] hover:underline">info@yourairtravel.nl</a></p>
                            <p class="mt-4 text-sm text-gray-500">KVK: [Jouw KVK Nummer] (optioneel)</p>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>

@endcomponent
