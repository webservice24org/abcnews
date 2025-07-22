<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 text-black">Tag Manager</h2>

    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
    <form wire:submit.prevent="{{ $editingTagId ? 'updateTag' : 'saveTag' }}" class="flex gap-4 mb-4 items-center">
        <input
            wire:model="{{ $editingTagId ? 'editingName' : 'name' }}"
            type="text"
            placeholder="Tag Name"
            class="text-black flex-grow border p-2 rounded"
        />

        <input
            wire:model="{{ $editingTagId ? 'editingSlug' : 'slug' }}"
            type="text"
            placeholder="Slug (optional)"
            title="Leave blank to auto-generate from name"
            class="text-black flex-grow border p-2 rounded"
        />

        <button
            type="submit"
            class="bg-{{ $editingTagId ? 'green' : 'blue' }}-600 text-white px-4 py-2 rounded"
        >
            {{ $editingTagId ? 'Update' : 'Add' }}
        </button>

        @if($editingTagId)
            <button
                type="button"
                wire:click="$set('editingTagId', null)"
                class="bg-gray-500 text-white px-4 py-2 rounded"
            >
                Cancel
            </button>
        @endif
    </form>
@endif




<table class="w-full border border-collapse">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-4 py-2 text-left text-black">Sl</th>
            <th class="border px-4 py-2 text-left text-black">Name</th>
            <th class="border px-4 py-2 text-left text-black">Slug</th>
            <th class="border px-4 py-2 text-left text-black">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tags as $tag)
            <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2 text-black">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2 text-black">{{ $tag->name }}</td>
                <td class="border px-4 py-2 text-black">{{ $tag->slug }}</td>
                <td class="border px-4 py-2">
                    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                        <button wire:click="editTag({{ $tag->id }})" class="text-white mr-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-60 rounded text-sm">Edit</button>
                        <button wire:click="confirmDeleteTag({{ $tag->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Delete</button>
                    @else
                        <span class="text-gray-400">Read Only</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    <div class="mt-4">
        {{ $tags->links() }}
    </div>
</div>

@push('scripts')
<script>
    window.Livewire.on('confirm-delete', (id) => {
        confirmDelete('deleteConfirmed', id);
    });

    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message);
    });
</script>

@endpush
