<div class="p-2 bg-white rounded shadow">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Photo News List</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse table-auto text-left">
        <thead class="bg-gray-100 text-black">
            <tr>
                <th class="p-3 border">#</th>
                <th class="p-3 border">Title</th>
                <th class="p-3 border">Thumbnail</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($photoNewsList as $index => $news)
                <tr>
                    <td class="p-3 border text-black">{{ $photoNewsList->firstItem() + $index }}</td>
                    <td class="p-3 border text-black">{{ $news->title }}</td>
                    <td class="p-3 border">
                        <img src="{{ asset('storage/' . $news->main_thumbnail) }}" class="h-12 w-16 object-cover rounded">
                    </td>
                    <td class="p-3 border">
                        <span class="text-sm px-2 py-1 rounded {{ $news->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($news->status) }}
                        </span>
                    </td>
                    <td class="p-3 border">
                        <a href="{{ route('admin.photo-news.edit', $news->id) }}" class="text-blue-600 hover:underline mr-3">Edit</a>

                        <button wire:click="confirmDelete({{ $news->id }})"
                            class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">No photo news found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $photoNewsList->links() }}
    </div>

    @if ($confirmingDelete)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-lg font-bold mb-4">Are you sure?</h2>
                <p class="mb-4 text-gray-700">This will permanently delete the photo news.</p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('confirmingDelete', false)" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded">Yes, Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
