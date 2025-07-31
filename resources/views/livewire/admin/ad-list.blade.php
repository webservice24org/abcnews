<div class="p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4 text-black">Advertisements</h2>

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border text-black">Ad Name</th>
                <th class="px-4 py-2 border text-black">Category / Sub-category</th>
                <th class="px-4 py-2 border text-black">Global Ad?</th>
                <th class="px-4 py-2 border text-black">Status</th>
                <th class="px-4 py-2 border text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ads as $ad)
                <tr>
                    <td class="px-4 py-2 border text-black">{{ $ad->ad_name }}</td>
                    <td class="px-4 py-2 border">
                        @if ($ad->categories->isNotEmpty())
                            @foreach ($ad->categories as $category)
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $category->name }}</span>
                            @endforeach
                        @endif
                        @if ($ad->subCategories->isNotEmpty())
                            @foreach ($ad->subCategories as $sub)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ $sub->name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td class="px-4 py-2 border text-center">
                        <span class="{{ $ad->is_global ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                            {{ $ad->is_global ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border">
                        
                        <button wire:click="toggleStatus({{ $ad->id }})"
                            class="px-3 py-1 rounded text-sm 
                            {{ $ad->status ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-400 hover:bg-gray-500 text-white' }}">
                            {{ $ad->status ? 'Enabled' : 'Disabled' }}
                        </button>
                    </td>
                    <td class="px-4 py-2 border space-x-2">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('ads.edit', $ad->id) }}" class="text-blue-600 hover:underline">
                                <flux:icon name="pencil-square" class="w-5 h-5" />
                            </a>
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
                                            $wire.delete({{ $ad->id }});
                                        }
                                    })
                                "
                                class="text-red-600 hover:text-red-800"
                                title="Delete"
                            >
                                <flux:icon name="trash" class="w-5 h-5" />
                            </button>

                            <button wire:click="preview({{ $ad->id }})" class="text-gray-800 hover:underline"><flux:icon name="eye" class="w-5 h-5" /></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Preview Modal -->
    @if ($showPreviewModal)
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow w-full max-w-lg">
                <h3 class="text-lg font-bold mb-4 text-black">Ad Preview</h3>
                <p class="text-black"><strong>Ad Name:</strong> {{ $previewAd->ad_name }}</p>

                @if ($previewAd->ad_image)
                    <div class="my-2">
                        <img src="{{ asset('storage/' . $previewAd->ad_image) }}" class="h-32 object-contain">
                    </div>
                @endif

                <p class="mb-2 text-black">
                    <strong >Categories:</strong>
                    @foreach ($previewAd->categories as $cat)
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $cat->name }}</span>
                    @endforeach
                </p>
                <p class="mb-2">
                    <strong>Sub-categories:</strong>
                    @foreach ($previewAd->subCategories as $sub)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ $sub->name }}</span>
                    @endforeach
                </p>
                <p class="text-black font-semibold mb-2">Status:</p>
                <button wire:click="toggleStatus({{ $previewAd->id }})"
                    class="px-3 py-1 rounded text-sm 
                    {{ $previewAd->status ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-400 hover:bg-gray-500 text-white' }}">
                    {{ $previewAd->status ? 'Enabled' : 'Disabled' }}
                </button>


                <button wire:click="$set('showPreviewModal', false)" class="mt-4 px-4 py-2 flex bg-gray-700 text-white rounded hover:bg-gray-800">Close</button>
            </div>
        </div>
    @endif
</div>

