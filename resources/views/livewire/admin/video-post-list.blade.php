<div class="p-6 bg-white rounded shadow">
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-black">Video Post List</h2>

        <input type="text" wire:model.debounce.500ms="search"
            placeholder="Search by title..."
            class="border px-3 py-1 rounded w-64 text-sm text-black">
    </div>


    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border border-gray-300 p-2 text-black text-center">#</th>
                <th class="border border-gray-300 p-2 text-black text-center">Title</th>
                <th class="border border-gray-300 p-2 text-black text-center">Thumbnail</th>
                <th class="border border-gray-300 p-2 text-black text-center">Status</th>
                <th class="border border-gray-300 p-2 text-black text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($videos as $index => $video)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2 text-black">{{ $index + 1 }}</td>
                    <td class="border p-2 text-black">{{ $video->video_title }}</td>
                    <td class="border p-2 text-black">
                        @if ($video->thumbnail)
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail" class="h-12 w-20 object-cover rounded">
                        @else
                            <span class="text-gray-500 italic">No image</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        <button wire:click="toggleStatus({{ $video->id }})"
                            class="px-3 py-1 rounded text-white 
                                {{ $video->status ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 hover:bg-gray-500' }}">
                            {{ $video->status ? 'Active' : 'Inactive' }}
                        </button>
                    </td>

                    <td class="p-2 text-center space-x-2">
                        <a href="{{ route('admin.video.edit', $video->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">Edit</a>
                        
                        <button
                            x-data
                            @click.prevent="
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'This ad will be permanently deleted!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.delete({{ $video->id }});
                                    }
                                })
                            "
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                            title="Delete"
                        >
                        Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-600">No videos found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    

</div>
