<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 text-black">Division Manager</h2>

    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <form wire:key="{{ $editingDivisionId ? 'edit-form' : 'add-form' }}"
            wire:submit.prevent="{{ $editingDivisionId ? 'updateDivision' : 'saveDivision' }}"
            class="flex flex-wrap gap-4 mb-4 items-center"
            style="gap: 0.5rem;">  {{-- optional custom gap if needed --}}

            <input wire:model="{{ $editingDivisionId ? 'editingName' : 'name' }}"
                type="text"
                placeholder="Division Name"
                class="text-black flex-grow min-w-[150px] border p-2 rounded" />

            <input wire:model="{{ $editingDivisionId ? 'editingSlug' : 'slug' }}"
                type="text"
                placeholder="Slug (optional)"
                title="Leave blank to auto-generate from name"
                class="text-black flex-grow min-w-[150px] border p-2 rounded" />

            <button type="submit"
                    class="bg-{{ $editingDivisionId ? 'green' : 'blue' }}-600 text-white px-4 py-2 rounded min-w-[100px]">
                {{ $editingDivisionId ? 'Update' : 'Add' }}
            </button>

            @if($editingDivisionId)
                <button type="button"
                        wire:click="$set('editingDivisionId', null)"
                        class="bg-gray-500 text-white px-4 py-2 rounded min-w-[100px]">
                    Cancel
                </button>
            @endif
        </form>
    @endif



    <table class="w-full border border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left text-black">Sl</th>
                <th class="border px-4 py-2 text-left text-black">Naame</th>
                <th class="border px-4 py-2 text-left text-black">slug</th>
                <th class="border px-4 py-2 text-left text-black">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($divisions as $division)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-black">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2 text-black">
                        {{ $division->name }}
                    </td>
                    <td class="border px-4 py-2 text-black">{{ $division->slug }}</td>
                    <td class="border px-4 py-2">
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <button wire:click="editDivision({{ $division->id }})" class="text-white mr-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-60 rounded text-sm">Edit</button>
                            <button wire:click="confirmDeleteDivision({{ $division->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Delete</button>
                        @else
                            <span class="text-gray-400">Read Only</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $divisions->links() }}
    </div>
</div>

@push('scripts')
<script>
    window.Livewire.on('confirm-delete', (id) => {
        confirmDelete('deleteConfirmed', id); // Make sure this name matches your Livewire listener
    });

    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message);
    });
</script>
@endpush
