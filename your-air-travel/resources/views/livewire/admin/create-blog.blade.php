<div>
    {{-- Assets voor Trix --}}
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">

                {{-- Header met Status Toggle --}}
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Nieuwe Blog Schrijven</h2>
                        <p class="text-sm text-gray-500">Deel je reiservaringen met de wereld.</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $is_active ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $is_active ? '● Publiceren' : '○ Concept (Gearchiveerd)' }}
                        </span>
                        <button wire:click="toggleStatus" type="button"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm border {{ $is_active ? 'bg-white text-gray-600 border-gray-200' : 'bg-green-600 text-white border-green-700' }}">
                            {{ $is_active ? 'Zet op Concept' : 'Maak Direct Live' }}
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="saveBlog" class="space-y-6">
                    {{-- Titel --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-tight">Titel</label>
                        <input type="text" wire:model="title" placeholder="Bijv: 10 tips voor je eerste reis naar Japan" class="mt-1 block w-full border-gray-200 bg-gray-50 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 p-3">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    {{-- Hoofdafbeelding --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-tight">Hoofdafbeelding</label>
                        <input type="file" wire:model="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700">

                        @if ($image)
                            <div class="mt-4 relative inline-block">
                                <img src="{{ $image->temporaryUrl() }}" class="h-48 w-full object-cover rounded-2xl shadow-md border-2 border-green-500">
                                <div class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded-lg text-[10px] font-bold shadow-sm">Preview</div>
                            </div>
                        @endif
                    </div>

                    {{-- Inhoud met Trix Editor --}}
                    <div wire:ignore>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-tight mb-2">Inhoud van de blog</label>
                        <input id="content" type="hidden" name="content" wire:model="content">
                        <trix-editor input="content" class="trix-content border-gray-200 bg-gray-50 rounded-xl shadow-sm min-h-[450px] focus:ring-green-500 p-4 leading-relaxed"></trix-editor>
                        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tags (Alpine.js selectie) --}}
                    <div x-data="{
                        open: false,
                        search: '',
                        selectedTags: @entangle('tags'),
                        availableTags: {{ json_encode($availableTags) }},
                        get filteredTags() {
                            return this.availableTags.filter(tag => tag.toLowerCase().includes(this.search.toLowerCase()) && !this.selectedTags.includes(tag))
                        },
                        addTag(tag) {
                            if(!this.selectedTags.includes(tag)) {
                                this.selectedTags.push(tag);
                            }
                            this.search = '';
                            this.open = false;
                        },
                        removeTag(tag) {
                            this.selectedTags = this.selectedTags.filter(t => t !== tag);
                        }
                    }" class="relative">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-tight mb-2">Tags Categorisering</label>

                        <div class="min-h-[50px] p-2 border border-gray-200 bg-gray-50 rounded-xl shadow-sm flex flex-wrap gap-2 items-center">
                            <template x-for="tag in selectedTags" :key="tag">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-[#2596be] text-white shadow-sm">
                                    <span x-text="tag"></span>
                                    <button type="button" @click="removeTag(tag)" class="ml-2 hover:text-red-200 focus:outline-none">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                                    </button>
                                </span>
                            </template>

                            <input
                                x-model="search"
                                @click="open = true"
                                @click.away="setTimeout(() => open = false, 200)"
                                @keydown.escape="open = false"
                                placeholder="Zoek en voeg tags toe..."
                                class="flex-1 border-none bg-transparent focus:ring-0 text-sm min-w-[200px]"
                            >
                        </div>

                        {{-- Dropdown suggesties --}}
                        <div x-show="open && filteredTags.length > 0"
                             class="absolute z-20 mt-2 w-full bg-white shadow-2xl max-h-60 rounded-xl py-2 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            <template x-for="tag in filteredTags" :key="tag">
                                <div @click="addTag(tag)"
                                     class="cursor-pointer select-none relative py-3 pl-4 pr-9 hover:bg-[#2596be] hover:text-white transition">
                                    <span x-text="tag" class="block truncate font-bold"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end pt-8 border-t border-gray-100">
                        <button type="submit" class="bg-green-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-green-700 transition shadow-xl shadow-green-100 hover:-translate-y-1 transform">
                            {{ $is_active ? '🚀 Blog Nu Publiceren' : '💾 Opslaan als Concept' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script voor Trix-sync --}}
    <script>
        document.addEventListener("trix-change", function(event) {
            @this.set('content', event.target.value);
        });
    </script>

    <style>
        .trix-content { width: 100%; }
        trix-toolbar .trix-button--icon-attach { display: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    </style>
</div>
