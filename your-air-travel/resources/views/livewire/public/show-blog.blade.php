<div class="py-12 bg-white min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Terug knop --}}
        <div class="mb-8">
            <a href="{{ route('public.blogs') }}" class="text-[#2596be] font-bold flex items-center hover:underline group inline-flex">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Terug naar alle artikelen
            </a>
        </div>

        {{-- Header (Alleen datum, geen auteur!) --}}
        <header class="mb-10">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 leading-tight tracking-tight">{{ $blog->title }}</h1>

            <div class="flex items-center text-gray-500 font-medium">
                {{-- Kalender Icoontje --}}
                <svg class="w-5 h-5 mr-2 text-[#2596be]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{-- Datum in mooi formaat (bijv. 24 Februari 2026) --}}
                <span>Gepubliceerd op {{ $blog->created_at->format('j F Y') }}</span>
            </div>
        </header>

        {{-- Hoofdafbeelding --}}
        @if($blog->image_path)
            <div class="mb-12 rounded-3xl overflow-hidden shadow-xl">
                <img src="{{ asset('storage/' . $blog->image_path) }}" class="w-full h-auto object-cover max-h-[450px]" alt="{{ $blog->title }}">
            </div>
        @endif

        {{-- De Content (Trix Output) --}}
        {{-- Let op: {!! !!} is belangrijk zodat Trix HTML goed wordt weergegeven --}}
        <div class="prose prose-lg md:prose-xl prose-blue max-w-none text-gray-700 leading-relaxed">
            {!! $blog->content !!}
        </div>

        {{-- Tags onderaan (Klikbaar in de toekomst) --}}
        @if(!empty($blog->tags))
            <div class="mt-16 pt-8 border-t border-gray-100">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Onderwerpen in dit artikel</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($blog->tags as $tag)
                        <span class="px-4 py-2 bg-[#2596be]/10 text-[#2596be] rounded-xl text-sm font-bold hover:bg-[#2596be] hover:text-white transition-colors cursor-pointer shadow-sm">
                            #{{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
