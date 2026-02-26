<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deal Niet Gevonden | YourAirTravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full text-center space-y-8">

            {{-- Groot 404 Icoon / Tekst --}}
            <div>
                <h1 class="text-9xl font-black text-[#2596be] drop-shadow-md">404</h1>
                <h2 class="mt-6 text-3xl font-black text-gray-900 tracking-tight">Oeps! Deal Gevlogen ✈️</h2>
                <p class="mt-4 text-lg text-gray-500 leading-relaxed">
                    Deze deal is helaas verlopen, gearchiveerd of bestaat niet meer. Maar niet getreurd, we hebben nog veel meer geweldige reizen voor je klaarstaan!
                </p>
            </div>

            {{-- Terug naar home knop --}}
            <div class="mt-8">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold rounded-xl text-white bg-[#e5764b] hover:bg-[#d4653a] shadow-lg shadow-[#e5764b]/30 transition-all transform hover:-translate-y-1">
                    Bekijk actieve deals
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                </a>
            </div>

            {{-- Extra linkje --}}
            <div class="mt-6">
                <a href="{{ route('search.results') }}" class="text-sm font-semibold text-gray-400 hover:text-[#2596be] transition-colors">
                    Of zoek handmatig naar een bestemming &rarr;
                </a>
            </div>

        </div>
    </div>

</body>
</html>
