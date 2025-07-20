<div class="p-6 bg-white rounded shadow">
     @if (session()->has('success'))
        <div class="text-green-600">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="text-red-600">{{ session('error') }}</div>
    @endif
    <h1 class="text-2xl font-bold mb-6 text-black">Published News</h1>

    @if($newsPosts->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border text-black">
                <thead class="bg-gray-100 text-black border-b">
                    <tr>
                        <th class="px-4 py-2 border">SL</th>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Author</th>
                        <th class="px-4 py-2 border">Categories</th>
                        <th class="px-4 py-2 border">Tags</th>
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newsPosts as $news)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">
                                <a href="{{ route('news.index', $news->slug) }}" class="text-blue-600 hover:underline">
                                    {{ $news->news_title }}
                                </a>
                            </td>
                            <td class="px-4 py-2 border">{{ $news->user->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-2 border">
                                {{ $news->categories->pluck('name')->implode(', ') }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $news->tags->pluck('name')->implode(', ') }}
                            </td>
                            <td class="px-4 py-2 border text-xs text-gray-500">
                                {{ optional($news->updated_at)->format('M d, Y') ?? optional($news->created_at)->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-2 border">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('news.index', $news->slug) }}" class="text-blue-600 hover:text-blue-800" title="View">
                                        <flux:icon name="eye" class="w-5 h-5" />
                                    </a>
                                    <a href="{{ route('posts.edit', $news->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                        <flux:icon name="pencil-square" class="w-5 h-5" />
                                    </a>
                                   <button wire:click="confirmDelete({{ $news->id }})"
                                        class="text-red-600 hover:underline"type="button"
                                            class="text-red-600 hover:text-red-800"
                                            title="Delete">
                                        <flux:icon name="trash" class="w-5 h-5" />
                                                                        
                                    </button>






                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $newsPosts->links() }}
        </div>
    @else
        <p class="text-black">No published news found.</p>
    @endif
</div>


