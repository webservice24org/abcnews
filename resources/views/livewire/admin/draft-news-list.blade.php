<div class="p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-black">Draft News</h1>

    @if($draftNews->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border text-black">
                <thead class="bg-gray-100 text-black border-b">
                    <tr>
                        <th class="px-4 py-2 border">SL</th>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Author</th>
                        <th class="px-4 py-2 border">Categories</th>
                        <th class="px-4 py-2 border">Tags</th>
                        <th class="px-4 py-2 border">Saved Date</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($draftNews as $index => $news)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $news->news_title }}</td>
                            <td class="px-4 py-2 border">{{ $news->user->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-2 border">
                                {{ $news->categories->pluck('name')->join(', ') }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $news->tags->pluck('name')->join(', ') }}
                            </td>
                            <td class="px-4 py-2 border text-xs text-gray-500">
                                {{ $news->updated_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-2 border flex items-center space-x-2">
                                @hasanyrole('Super Admin|Admin|Editor')
                                <a href="{{ route('posts.edit', $news->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <flux:icon name="pencil-square" class="w-5 h-5" />
                                </a>
                                @endhasanyrole
                                @hasanyrole('Admin|Super Admin')
                                <button wire:click="confirmDelete({{ $news->id }})"
                                    class="text-red-600 hover:underline"type="button"
                                        class="text-red-600 hover:text-red-800"
                                        title="Delete">
                                    <flux:icon name="trash" class="w-5 h-5" />
                                                                    
                                </button>
                                @endhasanyrole
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $draftNews->links() }}
        </div>
    @else
        <p class="text-black">No draft news found.</p>
    @endif
</div>
