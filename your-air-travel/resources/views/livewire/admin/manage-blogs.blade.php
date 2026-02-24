<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
            {{-- Filters --}}
            <div class="w-full lg:w-5/6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Zoek blog titel of ID..." class="w-full border-gray-300 rounded-md shadow-sm pl-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>

                <select wire:model.live="filter_author" class="border-gray-300 rounded-md shadow-sm text-gray-600">
                    <option value="">Alle Auteurs</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>

                <div wire:ignore class="relative">
                    <input type="text" x-data x-init="flatpickr($el, { mode: 'range', dateFormat: 'Y-m-d', altInput: true, altFormat: 'j M Y', locale: 'nl', placeholder: 'Aanmaakdatum...', onChange: function(s, dateStr) { $wire.set('filter_date', dateStr); } });" class="w-full border-gray-300 rounded-md shadow-sm pl-10 bg-white cursor-pointer">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                </div>

                <select wire:model.live="sort" class="border-gray-300 rounded-md shadow-sm text-gray-600">
                    <option value="newest">Nieuwste eerst</option>
                    <option value="oldest">Oudste eerst</option>
                </select>
            </div>

            <a href="{{ route('admin.blogs.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md font-bold text-xs uppercase tracking-widest hover:bg-green-700 whitespace-nowrap">
                + Nieuwe Blog
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-green-800">Beheer Blogs</h3></div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($blogs as $blog)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-bold text-gray-500">{{ $blog->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $blog->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $blog->author->name ?? 'Systeem' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $blog->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-blue-600 hover:text-blue-900">Bewerk</a>
                                    <button wire:click="deleteBlog({{ $blog->id }})" wire:confirm="Zeker weten?" class="text-red-600 hover:text-red-900">Verwijder</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-10 text-center text-gray-500">Geen blogs gevonden.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($blogs->hasPages()) <div class="px-6 py-4 border-t border-gray-200">{{ $blogs->links() }}</div> @endif
        </div>
    </div>
</div>
