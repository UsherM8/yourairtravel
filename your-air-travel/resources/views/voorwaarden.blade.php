@component('layouts.public')

    <div class="bg-gray-50 min-h-screen pb-20">
        {{-- Hero Sectie --}}
        <div class="relative py-20 bg-gradient-to-r from-[#2596be] to-[#1a7a9e] overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Algemene Voorwaarden</h1>
                <p class="text-lg text-blue-50">De spelregels voor het gebruik van YourAirTravel.</p>
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
                            Welkom op YourAirTravel. Deze Algemene Voorwaarden zijn van toepassing op elk gebruik van onze website en diensten. Door gebruik te maken van onze website ga je akkoord met deze voorwaarden. Lees ze daarom zorgvuldig door.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">2. Onze Dienstverlening (Affiliate)</h2>
                        <p class="mb-3">
                            YourAirTravel is een onafhankelijk platform dat reisdeals, vliegtickets en vakanties van externe aanbieders (zoals reisorganisaties en luchtvaartmaatschappijen) verzamelt en toont.
                        </p>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Wij verkopen <strong>zelf geen</strong> reizen, vliegtickets of accommodaties.</li>
                            <li>Wanneer je op een deal klikt, word je doorverwezen naar de website van de externe partner.</li>
                            <li>Een eventuele boeking of aankoop sluit je rechtstreeks af met deze partner. YourAirTravel is geen partij in deze overeenkomst.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">3. Prijzen en Beschikbaarheid</h2>
                        <p>
                            Wij doen ons uiterste best om de meest actuele prijzen en beschikbaarheid te tonen op YourAirTravel. Echter, omdat de prijzen van vliegtickets en vakanties constant veranderen bij onze partners, kunnen wij geen garanties geven over de juistheid van de getoonde prijzen of de beschikbaarheid van een deal. De uiteindelijke prijs en beschikbaarheid op de website van de aanbieder zijn altijd leidend.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">4. Aansprakelijkheid</h2>
                        <p class="mb-3">Omdat YourAirTravel slechts als bemiddelaar/doorverwijzer fungeert, zijn wij niet aansprakelijk voor:</p>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>De uitvoering van de geboekte reis, vertragingen, annuleringen of faillissementen van de externe aanbieder.</li>
                            <li>Schade (direct of indirect) die voortvloeit uit het gebruik van onze website of de onmogelijkheid om onze website te gebruiken.</li>
                            <li>Fouten, onvolledigheden of typfouten in de op onze website getoonde reisinformatie.</li>
                        </ul>
                        <p class="mt-4">Voor vragen, wijzigingen of klachten over je boeking dien je altijd contact op te nemen met de partij waar je de boeking hebt afgerond.</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">5. Intellectueel Eigendom</h2>
                        <p>
                            Alle inhoud op deze website, inclusief teksten, ontwerpen, logo's en software, is eigendom van YourAirTravel of onze licentiegevers. Het is niet toegestaan om zonder voorafgaande schriftelijke toestemming materiaal van deze website te kopiëren, te verspreiden of voor commerciële doeleinden te gebruiken.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">6. Wijzigingen</h2>
                        <p>
                            YourAirTravel behoudt zich het recht voor om deze Algemene Voorwaarden op elk moment te wijzigen. De meest actuele versie is altijd te vinden op deze pagina. We raden je aan deze pagina regelmatig te raadplegen.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-4">7. Contactgegevens</h2>
                        <p>
                            Mocht je vragen of opmerkingen hebben over deze Algemene Voorwaarden, dan kun je contact met ons opnemen via:
                        </p>
                        <div class="mt-4 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <p class="font-bold text-gray-900">YourAirTravel</p>
                            <p>E-mail: <a href="mailto:info@yourairtravel.nl" class="text-[#2596be] hover:underline">info@yourairtravel.nl</a></p>
                            <a href="{{ route('contact') }}" class="inline-block mt-4 text-[#2596be] font-bold hover:underline">Ga naar het contactformulier →</a>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>

@endcomponent
