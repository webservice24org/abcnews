<div class="p-6 bg-white rounded shadow">
    {{-- ✅ Section Title --}}
    <h2 class="text-lg font-semibold mb-6 text-gray-800">Category Manager</h2>

    {{-- ✅ Create / Edit Form --}}
    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <form wire:submit.prevent="saveCategory" class="flex flex-wrap gap-4 mb-6 items-center">
            <input wire:model.defer="name" type="text" placeholder="Category Name"
                class="text-black flex-1 min-w-[200px] border p-2 rounded focus:ring focus:ring-blue-200" />

            <input wire:model.defer="slug" type="text" placeholder="Slug (optional)"
                class="text-black flex-1 min-w-[200px] border p-2 rounded focus:ring focus:ring-blue-200"
                title="Leave blank to auto-generate from name" />

            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded whitespace-nowrap transition">
                {{ $editingCategoryId ? 'Update' : 'Add' }}
            </button>
        </form>
    @endif

    {{-- ✅ Filters --}}
    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <div class="flex gap-2 mb-6">
            <button wire:click="setFilter('all')"
                class="px-4 py-2 rounded text-sm font-medium transition 
                {{ $filter === 'all' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                Show All
            </button>
            <button wire:click="setFilter('active')"
                class="px-4 py-2 rounded text-sm font-medium transition 
                {{ $filter === 'active' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                Active
            </button>
            <button wire:click="setFilter('inactive')"
                class="px-4 py-2 rounded text-sm font-medium transition 
                {{ $filter === 'inactive' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                Inactive
            </button>
        </div>
    @endif

    {{-- ✅ Table Section --}}
    <div class="p-4 bg-white shadow rounded-lg">
        {{-- ✅ Search --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-md font-semibold text-gray-700">Categories</h3>
            <input type="text" wire:model.debounce.500ms="search"
                class="border rounded-lg px-3 py-2 text-sm text-gray-700 focus:ring focus:ring-blue-200"
                placeholder="Search categories...">
        </div>

        {{-- ✅ DataTable --}}
        <div class="overflow-x-auto">
            <table id="categories-table" class="min-w-full text-sm text-left text-gray-600">
                <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-6 py-3">Sl</th>
                        <th class="border px-6 py-3 cursor-pointer" wire:click="sortBy('name')">
                            Name 
                            @if($sortField === 'name')
                                {!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </th>
                        <th class="border px-6 py-3 cursor-pointer" wire:click="sortBy('slug')">
                            Slug
                            @if($sortField === 'slug')
                                {!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </th>
                        <th class="border px-6 py-3">Status</th>
                        <th class="border px-6 py-3 cursor-pointer" wire:click="sortBy('created_at')">
                            Created At
                            @if($sortField === 'created_at')
                                {!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </th>
                        <th class="border px-6 py-3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="border px-6 py-4">{{ $categories->firstItem() + $loop->index }}</td>
                            <td class="border px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                            <td class="border px-6 py-4">{{ $category->slug }}</td>
                            <td class="border px-6 py-4">
                                <button wire:click="toggleStatus({{ $category->id }})"
                                    class="px-3 py-1 rounded text-xs font-medium transition 
                                        {{ $category->status ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-red-500 hover:bg-red-600 text-white' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="border px-6 py-4">
                                {{$category->created_at}}
                            </td>
                            <td class="border px-6 py-4 flex space-x-2">
                                @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                                    <button wire:click="editCategory({{ $category->id }})"
                                        class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs transition">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDeleteCategory({{ $category->id }})"
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs transition">
                                        Delete
                                    </button>
                                @else
                                    <span class="text-gray-400">Read Only</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>

