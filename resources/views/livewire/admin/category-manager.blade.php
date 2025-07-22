<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 text-black">Category Manager</h2>

    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <form wire:submit.prevent="saveCategory" class="flex flex-wrap gap-4 mb-6 items-center">
            <input wire:model.defer="name" type="text" placeholder="Category Name"
                class="text-black flex-1 min-w-[200px] border p-2 rounded" />

            <input wire:model.defer="slug" type="text" placeholder="Slug (optional)"
                class="text-black flex-1 min-w-[200px] border p-2 rounded"
                title="Leave blank to auto-generate from name" />

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded whitespace-nowrap">
                {{ $editingCategoryId ? 'Update' : 'Add' }}
            </button>
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
            @foreach ($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-black">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2 text-black">{{ $category->name }}</td>
                    <td class="border px-4 py-2 text-black">{{ $category->slug }}</td>
                    <td class="border px-4 py-2">
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <button wire:click="editCategory({{ $category->id }})" class="text-white mr-2 px-3 py-1 bg-blue-500 rounded text-sm">Edit</button>
                            <button wire:click="confirmDeleteCategory({{ $category->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Delete</button>
                        @else
                            <span class="text-gray-400">Read Only</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
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