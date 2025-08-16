<div class="p-6 bg-white shadow rounded space-y-4">
    <div class="mb-4 flex justify-between items-center">
        <!-- Left: Title -->
        <div class="title">
            <h2 class="text-black text-lg font-semibold">Page list</h2>
        </div>

        <!-- Right: Search -->
        <div class="search">
            <input type="text" wire:model="search" placeholder="Search pages..."
                class="border px-3 py-2 rounded text-black w-64">
        </div>
    </div>


    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border p-2 text-black">Title</th>
                <th class="border p-2 text-black">Thumbnail</th>
                <th class="border p-2 text-black">Status</th>
                <th class="border p-2 text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pages as $page)
                <tr>
                    <td class="border p-2 text-black">{{ $page->title }}</td>
                    <td class="border p-2">
                        @if($page->page_thumbnail)
                            <img src="{{ asset('storage/' . $page->page_thumbnail) }}" 
                                 alt="Thumbnail" class="w-12 h-12 object-cover rounded">
                        @else
                            <span class="text-gray-500">No Image</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        <button 
                            wire:click="toggleStatus({{ $page->id }})"
                            class="px-3 py-1 rounded text-white 
                                {{ $page->status === 'published' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}">
                            {{ $page->status === 'published' ? 'Active' : 'Inactive' }}
                        </button>
                    </td>

                    <td class="border p-2 flex gap-2">
                        <a href="{{ route('pages.edit', $page->id) }}" title="Edit">
                            <flux:icon name="pencil-square" class="w-5 h-5 text-blue-600" />
                        </a>
                        <a href="{{ route('page.show', $page->slug) }}" target="__blank" title="View">
                            <flux:icon name="eye" class="w-5 h-5 text-gray-600" />
                        </a>
                        <button
                            x-data
                            @click.prevent="
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'This page will be permanently deleted!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.deletePage({{ $page->id }});
                                    }
                                })
                            "
                            class="text-red-600 hover:text-red-800"
                            title="Delete"
                        >
                            <flux:icon name="trash" class="w-5 h-5" />
                        </button>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border p-2 text-center text-gray-500">No pages found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $pages->links() }}
    </div>
</div>
