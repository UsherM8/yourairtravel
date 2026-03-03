<div class="py-12 bg-gray-50 min-h-screen">
    {{-- Flatpickr voor de datum range --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/nl.js"></script>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Succes melding --}}
        @if (session()->has('message'))
            <div class="bg-green-500 text-white px-6 py-4 rounded-2xl font-bold shadow-lg mb-6 flex justify-between items-center animate-bounce">
                <span>✨ {{ session('message') }}</span>
                <button @click="open = false" class="text-white/50 hover:text-white">×</button>
            </div>
        @endif

        {{-- HEADER: Zoekbalk + Filters + Create Knop --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">

            {{-- Linker kant: Zoeken & Filters --}}
            <div class="w-full lg:w-5/6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-3">

                {{-- 1. Zoekbalk --}}
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Zoek op titel of ID..."
                        class="w-full border-gray-200 bg-white rounded-xl shadow-sm pl-10 focus:ring-[#2596be] focus:border-[#2596be] text-sm"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- 2. Filter: Status --}}
                <div>
                    <select wire:model.live="filter_status" class="w-full border-gray-200 bg-white rounded-xl shadow-sm text-sm font-bold text-gray-600">
                        <option value="all">Alle statussen</option>
                        <option value="active">Alleen Live ✅</option>
                        <option value="archived">Gearchiveerd 📦</option>
                    </select>
                </div>

                {{-- 3. Filter: Auteur --}}
                <div>
                    <select wire:model.live="filter_author" class="w-full border-gray-200 bg-white rounded-xl shadow-sm text-sm text-gray-600">
                        <option value="">Alle Auteurs</option>
                        @foreach($authors ?? [] as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 4. Filter: Datum (Range) --}}
                <div wire:ignore class="relative">
                    <input
                        type="text"
                        x-data
                        x-init="
                            flatpickr($el, {
                                mode: 'range',
                                dateFormat: 'Y-m-d',
                                altInput: true,
                                altFormat: 'j M Y',
                                locale: 'nl',
                                placeholder: 'Publicatiedatum...',
                                onChange: function(selectedDates, dateStr, instance) {
                                    $wire.set('filter_date', dateStr);
                                }
                            });
                        "
                        class="w-full border-gray-200 bg-white rounded-xl shadow-sm pl-10 text-sm text-gray-600 cursor-pointer"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                {{-- 5. Sorteer dropdown --}}
                <div>
                    <select wire:model.live="sort" class="w-full border-gray-200 bg-white rounded-xl shadow-sm text-sm font-bold text-[#2596be]">
                        <option value="newest">Nieuwste eerst</option>
                        <option value="oldest">Oudste eerst</option>
                    </select>
                </div>

            </div>

            <a href="{{ route('admin.blogs.create') }}" class="bg-[#2596be] hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg transition-all ml-auto lg:ml-0">
                + Nieuwe Blog
            </a>
        </div>

        {{-- BLOG LIJST --}}
        <div class="space-y-4">
            @forelse($blogs as $blog)
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden flex items-center p-4 {{ !$blog->is_active ? 'opacity-60 grayscale-[0.5]' : '' }}">

                    {{-- Thumbnail & Info --}}
                    <div class="flex-1 flex items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 bg-gray-100 border border-gray-50">
                            @if($blog->image_path)
                                {{-- HOSTINGER FIX: Check beide locaties --}}
                                <img src="{{ file_exists(public_path('uploads/' . $blog->image_path)) ? asset('uploads/' . $blog->image_path) : asset('storage/' . $blog->image_path) }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">🖼️</div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-widest {{ $blog->is_active ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ $blog->is_active ? 'Live' : 'Archief' }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $blog->created_at->format('d M Y') }}</span>
                            </div>

                            {{-- DE DYNAMISCHE LINK --}}
                            @if($blog->is_active)
                                <a href="{{ route('public.blog.show', $blog->id) }}" target="_blank" class="block">
                                    <h3 class="text-lg font-black text-gray-900 group-hover:text-[#2596be] transition-colors truncate">{{ $blog->title }}</h3>
                                </a>
                            @else
                                <h3 class="text-lg font-black text-gray-400 line-through truncate cursor-not-allowed" title="Gearchiveerde blogs zijn niet zichtbaar op de site">
                                    {{ $blog->title }}
                                </h3>
                            @endif

                            <p class="text-xs text-gray-500 font-medium">
                                Door {{ $blog->author->name ?? 'Onbekend' }} •
                                <span class="text-[#2596be] font-bold">🔥 {{ $blog->click_count ?? 0 }} views</span>
                            </p>
                        </div>
                    </div>

                    {{-- Actie Knoppen --}}
                    <div class="flex items-center gap-2 ml-4 px-4 border-l border-gray-50">
                        {{-- Quick Archive Toggle --}}
                        <button wire:click="toggleArchive({{ $blog->id }})" class="p-2.5 rounded-xl transition-colors {{ $blog->is_active ? 'text-orange-400 hover:bg-orange-50' : 'text-green-500 hover:bg-green-50' }}" title="Status wijzigen">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </button>

                        {{-- Edit --}}
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="p-2.5 rounded-xl hover:bg-blue-50 text-blue-400 hover:text-[#2596be] transition-colors" title="Bewerken">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>

                        {{-- Delete --}}
                        <button onclick="confirm('Weet je het zeker? Deze blog wordt definitief verwijderd.') || event.stopImmediatePropagation()" wire:click="deleteBlog({{ $blog->id }})" class="p-2.5 rounded-xl hover:bg-red-50 text-red-300 hover:text-red-600 transition-colors" title="Verwijderen">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-gray-100 shadow-inner">
                    <p class="text-gray-400 font-bold italic">Geen blogs gevonden. Tijd om te schrijven! ✍️</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    </div>
</div>
