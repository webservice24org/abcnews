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

     @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <div class="flex gap-4 mb-4">
            <button wire:click="setFilter('active')"
                class="px-4 py-2 rounded {{ $filter === 'active' ? 'bg-green-600 text-white' : 'bg-gray-200 text-black' }}">
                Active Categories
            </button>
            <button wire:click="setFilter('inactive')"
                class="px-4 py-2 rounded {{ $filter === 'inactive' ? 'bg-red-600 text-white' : 'bg-gray-200 text-black' }}">
                Inactive Categories
            </button>
            <button wire:click="setFilter('all')"
                class="px-4 py-2 rounded {{ $filter === 'all' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-black' }}">
                Show All
            </button>
        </div>
    @endif


    <table class="w-full border border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left text-black">Sl</th>
                <th class="border px-4 py-2 text-left text-black">Name</th>
                <th class="border px-4 py-2 text-left text-black">Slug</th>
                <th class="border px-4 py-2 text-left text-black">Status</th>
                <th class="border px-4 py-2 text-left text-black">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-black">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2 text-black">{{ $category->name }}</td>
                    <td class="border px-4 py-2 text-black">{{ $category->slug }}</td>
                    
                    {{-- ✅ Status toggle button --}}
                    <td class="border px-4 py-2">
                        <button wire:click="toggleStatus({{ $category->id }})"
                            class="px-3 py-1 rounded text-sm 
                                   {{ $category->status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            {{ $category->status ? 'Active' : 'Inactive' }}
                        </button>
                    </td>

                    <td class="border px-4 py-2">
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <button wire:click="editCategory({{ $category->id }})"
                                class="text-white mr-2 px-3 py-1 bg-blue-500 rounded text-sm">Edit</button>
                            <button wire:click="confirmDeleteCategory({{ $category->id }})"
                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Delete</button>
                        @else
                            <span class="text-gray-400">Read Only</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
