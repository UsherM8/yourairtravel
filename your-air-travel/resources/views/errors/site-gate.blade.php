<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourAirTravel - Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen font-sans">
    <div class="max-w-md w-full p-8 bg-white rounded-[2rem] shadow-2xl text-center">
        <img src="{{ asset('images/logo.png') }}" class="h-12 mx-auto mb-6" alt="Logo">
        <h1 class="text-2xl font-black text-slate-800 mb-2 uppercase tracking-tight">Stakeholder Preview</h1>
        <p class="text-slate-500 mb-8 text-sm font-medium">Dit platform is momenteel in ontwikkeling. Voer het wachtwoord in om de demonstratie te bekijken.</p>

        <form method="GET" action="" class="space-y-4">
            <input type="password" name="site_password" placeholder="Geheim wachtwoord..."
                   class="w-full px-5 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-[#2596be] text-center font-bold text-lg" autofocus>

            @if(session('error'))
                <p class="text-red-500 text-xs font-bold">{{ session('error') }}</p>
            @endif

            <button type="submit" class="w-full py-4 bg-[#2596be] text-white font-black rounded-2xl hover:bg-slate-800 transition-all uppercase tracking-widest shadow-lg active:scale-95">
                Toegang Krijgen
            </button>
        </form>
        <p class="mt-8 text-[10px] text-slate-300 font-bold uppercase tracking-widest">© 2024 YourAirTravel Development Team</p>
    </div>
</body>
</html>
