<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 text-black">Sub-Category Manager</h2>

   @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <form wire:submit.prevent="{{ $editingSubCategoryId ? 'updateSubCategory' : 'saveSubCategory' }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 items-center">

            <!-- Category Dropdown -->
            <select wire:model="{{ $editingSubCategoryId ? 'editingCategoryId' : 'category_id' }}"
                    class="text-black w-full border p-2 rounded">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <!-- Sub-category name -->
            <input wire:model="{{ $editingSubCategoryId ? 'editingName' : 'name' }}"
                type="text"
                placeholder="Sub-Category Name"
                class="text-black w-full border p-2 rounded" />

            <!-- Slug (optional) -->
            <input wire:model="{{ $editingSubCategoryId ? 'editingSlug' : 'slug' }}"
                type="text"
                placeholder="Slug (optional)"
                class="text-black w-full border p-2 rounded"
                title="Leave blank to auto-generate from name" />

            <!-- Submit / Cancel Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="bg-{{ $editingSubCategoryId ? 'green' : 'blue' }}-600 text-white px-3 py-2 rounded text-sm">
                    {{ $editingSubCategoryId ? 'Update' : 'Add' }}
                </button>

                @if($editingSubCategoryId)
                    <button type="button" wire:click="$set('editingSubCategoryId', null)"
                            class="bg-gray-500 text-white px-3 py-2 rounded text-sm">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    @endif





    <table class="w-full border border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left text-black">Sl</th>
                <th class="border px-4 py-2 text-left text-black">Category</th>
                <th class="border px-4 py-2 text-left text-black">Sub-Category</th>
                <th class="border px-4 py-2 text-left text-black">Slig</th>
                <th class="border px-4 py-2 text-left text-black">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subCategories as $sub)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-black">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2 text-black">{{ $sub->category->name }}</td>
                    <td class="border px-4 py-2 text-black">{{ $sub->name }}</td>
                    <td class="border px-4 py-2 text-black">{{ $sub->slug }}</td>
                    <td class="border px-4 py-2">
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <button wire:click="editSubCategory({{ $sub->id }})" class="text-white mr-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-60 rounded text-sm">Edit</button>
                            <button wire:click="confirmDeleteSubCategory({{ $sub->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Delete</button>
                        @else
                            <span class="text-gray-400">Read Only</span>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="mt-4">
        {{ $subCategories->links() }}
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
