{{-- resources/views/livewire/admin/homepage-manager.blade.php --}}
<div class="p-6 bg-white rounded shadow space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800">Homepage Builder</h2>
        <button wire:click="openCreateModal"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add Section</button>
    </div>

    {{-- Sections list (drag & drop) --}}
    <div x-data
         x-init="
            const el = $refs.sortRoot;
            Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                onEnd: (evt) => {
                    const ids = Array.from(el.children).map(li => li.getAttribute('data-id'));
                    $wire.updateOrder(ids);
                }
            });
         ">
        <ul class="space-y-3" x-ref="sortRoot">
            @forelse($sections as $s)
                <li class="border rounded-lg p-3 flex items-center gap-4 bg-gray-50" data-id="{{ $s->id }}">
                    <div class="drag-handle cursor-move select-none text-gray-400 text-xl">⠿</div>
                    <img src="{{ $componentOptions[$s->component]['preview'] ?? '/images/section-previews/placeholder.png' }}"
                         class="w-20 h-12 object-cover rounded border">

                    <div class="flex-1">
                        <div class="font-semibold text-gray-800">
                            {{ $s->title }}
                            <span class="text-xs text-gray-500">({{ $componentOptions[$s->component]['label'] ?? $s->component }})</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            Category: {{ optional($s->category)->name ?? '—' }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button wire:click="toggleStatus({{ $s->id }})"
                                class="px-3 py-1 text-xs rounded {{ $s->status ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }}">
                            {{ $s->status ? 'Active' : 'Hidden' }}
                        </button>
                        <button wire:click="openEditModal({{ $s->id }})"
                                class="px-3 py-1 text-xs rounded bg-blue-500 text-white">Edit</button>
                        <button wire:click="delete({{ $s->id }})"
                                class="px-3 py-1 text-xs rounded bg-red-600 text-white"
                                onclick="return confirm('Delete this section?')">Delete</button>
                    </div>
                </li>
            @empty
                <p class="text-gray-500">No sections yet. Click “Add Section”.</p>
            @endforelse
        </ul>
    </div>

    {{-- Modal --}}
    <div x-data="{ open: @entangle('modalOpen') }"
         x-show="open" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div @click.outside="open=false"
             class="bg-white w-full max-w-4xl rounded-lg shadow p-6 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">{{ $editingId ? 'Edit Section' : 'Add Section' }}</h3>
                <button @click="open=false" class="text-gray-500 text-xl leading-none">&times;</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Visual picker --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2 text-gray-700">Select Section Layout</label>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($componentOptions as $key => $opt)
                            <label class="cursor-pointer group">
                                <input type="radio" class="hidden" wire:model="component" value="{{ $key }}">
                                <div class="border rounded-lg p-2 group-hover:shadow
                                            {{ $component === $key ? 'ring-2 ring-blue-500' : '' }}">
                                    <img src="{{ $opt['preview'] }}" class="w-full h-20 object-cover rounded mb-2">
                                    <div class="text-sm font-medium text-gray-800">{{ $opt['label'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $opt['desc'] }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('component') <p class="text-red-600 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Fields --}}
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model.defer="title"
                               class="w-full border rounded px-3 py-2 text-gray-800">
                        @error('title') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Category</label>
                        <select wire:model="category_id" class="w-full border rounded px-3 py-2 text-gray-800">
                            <option value="">— None —</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 mt-1">Slug will be taken from the selected category automatically in frontend.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <input id="status" type="checkbox" wire:model="status" class="rounded">
                        <label for="status" class="text-sm text-gray-700">Active</label>
                    </div>

                    <div class="pt-2">
                        <button wire:click="save"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Save
                        </button>
                        <button @click="open=false"
                                class="ml-2 bg-gray-200 text-gray-800 px-4 py-2 rounded">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    {{-- SortableJS CDN (or install via npm) --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
@endpush
