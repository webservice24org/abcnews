<div>
    <div class="mb-4 flex justify-between items-center">
        <input type="text" wire:model="search" placeholder="Search pages..."
               class="border px-3 py-2 rounded w-1/3">

        @if (session()->has('message'))
            <span class="text-green-600">{{ session('message') }}</span>
        @endif
    </div>

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border p-2">Title</th>
                <th class="border p-2">Thumbnail</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pages as $page)
                <tr>
                    <td class="border p-2">{{ $page->title }}</td>
                    <td class="border p-2">
                        @if($page->page_thumbnail)
                            <img src="{{ asset('storage/' . $page->page_thumbnail) }}" 
                                 alt="Thumbnail" class="w-12 h-12 object-cover rounded">
                        @else
                            <span class="text-gray-500">No Image</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        <span class="{{ $page->status ? 'text-green-600' : 'text-red-600' }}">
                            {{ $page->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2">
                        <a href="" title="Edit">
                            <flux:icon name="pencil-square" class="w-5 h-5 text-blue-600" />
                        </a>
                        <a href="" title="View">
                            <flux:icon name="eye" class="w-5 h-5 text-gray-600" />
                        </a>
                        <button wire:click="deletePage({{ $page->id }})" 
                                onclick="return confirm('Are you sure you want to delete this page?')" 
                                title="Delete">
                            <flux:icon name="trash" class="w-5 h-5 text-red-600" />
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
