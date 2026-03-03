<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    {{-- FILTER BALK --}}
    <div class="mb-12 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4">

        {{-- 1. Zoekbalk --}}
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Zoek een reisverhaal..."
                   class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm text-gray-700 font-medium transition-colors">
        </div>

        {{-- 2. Onderwerp Filter --}}
        <div class="w-full md:w-64">
            <select wire:model.live="selectedTag"
                    class="w-full py-3 pl-4 pr-10 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm text-gray-700 font-medium cursor-pointer">
                <option value="">Alle Onderwerpen</option>
                @foreach($availableTags as $tag)
                    <option value="{{ $tag }}">{{ $tag }}</option>
                @endforeach
            </select>
        </div>

        {{-- 3. Sorteer Opties --}}
        <div class="w-full md:w-56">
            <select wire:model.live="sort"
                    class="w-full py-3 pl-4 pr-10 rounded-xl border-gray-200 focus:border-[#2596be] focus:ring-[#2596be] shadow-sm text-gray-700 font-medium cursor-pointer">
                <option value="desc">Nieuwste eerst</option>
                <option value="asc">Oudste eerst</option>
            </select>
        </div>

    </div>

    {{-- Blog Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($blogs as $blog)
            <article class="flex flex-col overflow-hidden rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 bg-white border border-gray-100">
                {{-- Foto (HOSTINGER FIX) --}}
                <a href="{{ route('public.blog.show', $blog->id) }}" class="flex-shrink-0 block overflow-hidden">
                    @if($blog->image_path)
                        {{-- Check of afbeelding in uploads staat, anders fallback naar storage --}}
                        <img class="h-56 w-full object-cover transform hover:scale-105 transition-transform duration-500"
                             src="{{ file_exists(public_path('uploads/' . $blog->image_path)) ? asset('uploads/' . $blog->image_path) : asset('storage/' . $blog->image_path) }}"
                             alt="{{ $blog->title }}">
                    @else
                        <div class="h-56 w-full bg-gray-200 flex items-center justify-center text-gray-400 font-bold italic uppercase tracking-tighter">
                            YourAirTravel
                        </div>
                    @endif
                </a>

                {{-- Content --}}
                <div class="flex flex-1 flex-col justify-between p-6">
                    <div class="flex-1">
                        {{-- Tags --}}
                        <div class="flex flex-wrap gap-2 mb-3">
                            @php $tags = is_array($blog->tags) ? $blog->tags : json_decode($blog->tags, true) ?? []; @endphp
                            @foreach(array_slice($tags, 0, 3) as $tag)
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-[#2596be] uppercase tracking-wide">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>

                        <a href="{{ route('public.blog.show', $blog->id) }}" class="mt-2 block group">
                            <p class="text-xl font-black text-gray-900 group-hover:text-[#2596be] transition-colors leading-tight uppercase tracking-tighter">
                                {{ $blog->title }}
                            </p>
                            <p class="mt-3 text-sm text-gray-500 line-clamp-3 font-medium leading-relaxed">
                                {{ Str::limit(strip_tags($blog->content), 120) }}
                            </p>
                        </a>
                    </div>

                    {{-- Footer --}}
                    <div class="mt-6 pt-4 border-t border-gray-50">
                        <div class="flex items-center text-xs text-gray-400 font-bold uppercase tracking-widest">
                            <svg class="w-4 h-4 mr-2 text-[#2596be]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $blog->created_at->format('j M Y') }}
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <div class="text-5xl mb-4">✍️</div>
                <h3 class="text-xl font-bold text-gray-900">Nog geen verhalen...</h3>
                <p class="text-gray-500">We zijn druk bezig met het schrijven van nieuwe reistips!</p>
            </div>
        @endforelse
    </div>

    {{-- Laad Meer Knop --}}
    @if(count($blogs) < $totalBlogs)
        <div class="mt-16 flex justify-center">
            <button
                wire:click="loadMore"
                class="inline-flex items-center px-10 py-4 bg-white border-2 border-[#2596be] text-[#2596be] font-black rounded-2xl hover:bg-[#2596be] hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg"
            >
                <span wire:loading.remove wire:target="loadMore">MEER ARTIKELEN LADEN</span>
                <span wire:loading wire:target="loadMore" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-current" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    BEZIG MET LADEN...
                </span>
            </button>
        </div>
    @endif
</div>
