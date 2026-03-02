@props(['blog'])

<article class="flex flex-col bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden h-full group">
    {{-- Afbeelding --}}
    <a href="{{ route('public.blog.show', $blog->id) }}" class="relative block overflow-hidden aspect-[16/9] flex-shrink-0">
        @if($blog->image_path)
            <img src="{{ asset('storage/' . $blog->image_path) }}"
                 alt="{{ $blog->title }}"
                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 font-bold italic">
                YourAirTravel
            </div>
        @endif

        <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase text-[#2596be] shadow-sm">
            {{ $blog->created_at->format('j M Y') }}
        </div>
    </a>

    {{-- Content --}}
    <div class="p-6 flex flex-col flex-grow">
        {{-- Tags --}}
        <div class="flex flex-wrap gap-2 mb-3">
            @foreach(array_slice($blog->tags ?? [], 0, 2) as $tag)
                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-blue-600">
                    {{ $tag }}
                </span>
            @endforeach
        </div>

        <h3 class="text-xl font-extrabold text-gray-900 mb-3 group-hover:text-[#2596be] transition-colors leading-snug">
            <a href="{{ route('public.blog.show', $blog->id) }}">
                {{ $blog->title }}
            </a>
        </h3>

        <p class="text-gray-500 text-sm font-medium line-clamp-3 mb-6">
            {{ Str::limit(strip_tags($blog->content), 120) }}
        </p>

        {{-- Footer --}}
        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
            <span class="text-xs text-gray-400 font-bold flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                5 MIN LEESTIJD
            </span>

            <a href="{{ route('public.blog.show', $blog->id) }}" class="text-sm font-bold text-gray-900 flex items-center group-hover:text-[#2596be] transition-colors">
                Lees meer
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
</article>
