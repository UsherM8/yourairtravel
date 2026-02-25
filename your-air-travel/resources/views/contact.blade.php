@component('layouts.public')

    <div class="bg-white">
        {{-- Hero Sectie --}}
        <div class="relative py-24 bg-gradient-to-r from-[#2596be] to-[#1a7a9e] overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Neem Contact Op</h1>
                <p class="text-xl text-blue-50 max-w-2xl mx-auto">Heb je een vraag over een deal, een samenwerking, of wil je gewoon hallo zeggen? We horen graag van je!</p>
            </div>
            {{-- Decoratieve cirkel --}}
            <div class="absolute top-0 left-0 -translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Contact Content --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

                {{-- Linker Kolom: Contact Informatie --}}
                <div>
                    <h2 class="text-3xl font-black text-gray-900 mb-6 uppercase tracking-tight">Hoe kunnen we helpen?</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-10">
                        We proberen altijd binnen 24 uur te reageren. Kijk ook eens bij onze veelgestelde vragen, misschien staat je antwoord daar al tussen!
                    </p>

                    <div class="space-y-8">
                        {{-- Email --}}
                        <div class="flex items-start group">
                            <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-gray-900">E-mail ons</h3>
                                <p class="text-gray-500 mt-1">Voor algemene vragen en support.</p>
                                <a href="mailto:info@yourairtravel.nl" class="text-[#2596be] font-bold mt-2 inline-block hover:underline">info@yourairtravel.nl</a>
                            </div>
                        </div>

                        {{-- Social Media --}}
                        <div class="flex items-start group">
                            <div class="w-14 h-14 bg-blue-100 text-[#2596be] rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-gray-900">Social Media</h3>
                                <p class="text-gray-500 mt-1">Volg ons voor de nieuwste flash deals!</p>
                                <div class="flex gap-4 mt-3">
                                    <a href="#" class="text-gray-400 hover:text-[#2596be] transition-colors">
                                        <span class="sr-only">Facebook</span>
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors">
                                        <span class="sr-only">Instagram</span>
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Rechter Kolom: Het Formulier --}}
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10 relative">
                    {{-- Subtiel achtergrond accent --}}
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -z-10 opacity-50"></div>

                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-bold text-gray-700 mb-2">Voornaam</label>
                                <input type="text" name="first_name" id="first_name" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm transition-colors" placeholder="Kees">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-bold text-gray-700 mb-2">Achternaam</label>
                                <input type="text" name="last_name" id="last_name" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm transition-colors" placeholder="Jansen">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">E-mailadres</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm transition-colors" placeholder="kees@voorbeeld.nl">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Onderwerp</label>
                            <select name="subject" id="subject" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm transition-colors">
                                <option>Vraag over een deal</option>
                                <option>Samenwerken met YourAirTravel</option>
                                <option>Probleem met de website</option>
                                <option>Anders</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Jouw bericht</label>
                            <textarea name="message" id="message" rows="5" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm transition-colors resize-none" placeholder="Typ hier je bericht..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-[#2596be] hover:bg-[#1a7a9e] text-white font-black text-lg py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1">
                            Verstuur Bericht
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endcomponent
