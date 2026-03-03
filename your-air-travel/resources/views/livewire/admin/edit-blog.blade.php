<div>
    {{-- Assets voor Trix --}}
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">

                {{-- Header met Status Toggle --}}
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Blog Aanpassen</h2>
                    <button wire:click="toggleArchive" type="button"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition {{ $is_active ? 'bg-orange-100 text-orange-700 hover:bg-orange-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                        {{ $is_active ? '📦 Archiveer Blog' : '🚀 Zet Blog Live' }}
                    </button>
                </div>

                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-500 text-white rounded-lg font-bold">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="updateBlog" class="space-y-6">
                    {{-- Titel --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Titel</label>
                        <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Hoofdafbeelding --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Afbeelding (Cover)</label>
                        <input type="file" wire:model="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700">

                        <div class="mt-4 flex gap-4">
                            @if ($image)
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1 font-bold">Nieuwe preview:</p>
                                    <img src="{{ $image->temporaryUrl() }}" class="h-40 w-full object-cover rounded-lg border-2 border-green-500">
                                </div>
                            @elseif ($existingImage)
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1 font-bold">Huidige afbeelding:</p>
                                    {{-- HOSTINGER FIX: Check beide locaties --}}
                                    <img src="{{ file_exists(public_path('uploads/' . $existingImage)) ? asset('uploads/' . $existingImage) : asset('storage/' . $existingImage) }}"
                                         class="h-40 w-full object-cover rounded-lg border">
                                </div>
                            @endif
                        </div>
                        @error('image') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Inhoud met Trix Editor --}}
                    <div wire:ignore>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Inhoud</label>
                        <input id="content" type="hidden" name="content" wire:model="content">
                        <trix-editor input="content" class="trix-content border-gray-300 rounded-md shadow-sm min-h-[400px] focus:ring-green-500"></trix-editor>
                        @error('content') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tags met Alpine.js --}}
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags Categorisering</label>

                        <div class="min-h-[45px] p-1.5 border border-gray-300 rounded-md shadow-sm bg-white flex flex-wrap gap-2 items-center focus-within:ring-2 focus-within:ring-green-500 focus-within:border-green-500">
                            <template x-for="tag in selectedTags" :key="tag">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <span x-text="tag"></span>
                                    <button type="button" @click="removeTag(tag)" class="ml-1.5 inline-flex items-center justify-center text-green-400 hover:text-green-600 focus:outline-none">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                                    </button>
                                </span>
                            </template>

                            <input
                                x-model="search"
                                @click="open = true"
                                @click.away="setTimeout(() => open = false, 200)"
                                @keydown.escape="open = false"
                                placeholder="Zoek tags..."
                                class="flex-1 border-none focus:ring-0 text-sm min-w-[150px] p-1"
                            >
                        </div>

                        <div x-show="open && filteredTags.length > 0"
                             class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            <template x-for="tag in filteredTags" :key="tag">
                                <div @click="addTag(tag)"
                                     class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-green-600 hover:text-white transition">
                                    <span x-text="tag" class="block truncate"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.blogs.index') }}" class="text-gray-500 font-bold hover:underline">Annuleren</a>
                        <button type="submit" wire:loading.attr="disabled" class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg disabled:opacity-50">
                            <span wire:loading.remove wire:target="updateBlog">Wijzigingen Opslaan</span>
                            <span wire:loading wire:target="updateBlog">Verwerken...</span>
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
        .trix-content { width: 100%; border-radius: 0.375rem !important; }
        trix-toolbar .trix-button--icon-attach { display: none; }
    </style>
</div>
