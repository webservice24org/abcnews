<div class="p-6 bg-white rounded shadow">
  
@if (session()->has('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

    <h1 class="text-2xl font-bold mb-6 text-black">Trashed News</h1>

    @if($trashedNews->count())
        <table class="min-w-full table-auto border border-black text-black">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">SL</th>
                    <th class="border px-3 py-2">Title</th>
                    <th class="border px-3 py-2">Author</th>
                    <th class="border px-3 py-2">Deleted At</th>
                    <th class="border px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trashedNews as $news)
                    <tr>
                        <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-3 py-2">{{ $news->news_title }}</td>
                        <td class="border px-3 py-2">{{ $news->user->name ?? 'N/A' }}</td>
                        <td class="border px-3 py-2">{{ $news->deleted_at->format('M d, Y H:i') }}</td>
                        <td class="border px-3 py-2 space-x-2">
                            <button 
                                wire:click="restorePost({{ $news->id }})"
                                class="text-green-600 hover:text-green-800" 
                                title="Restore"
                            >
                                <flux:icon name="arrow-uturn-left" />
                            </button>



                            <button wire:click="forceDeleteConfirmed({{ $news->id }})"
        type="button"
        class="text-red-600 hover:text-red-800"
        title="Delete Forever">
    <flux:icon name="trash" />
</button>









                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $trashedNews->links() }}
        </div>
    @else
        <p class="text-black">No trashed news found.</p>
    @endif
</div>




