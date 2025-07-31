<div class="p-6 bg-white rounded shadow">
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-4">

        <div>
            <label class="font-bold text-black">Video Title <span class="text-red-600">*</span></label>
            <input type="text" wire:model="video_title" class="text-black w-full p-2 border rounded">
            @error('video_title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-bold text-black">Short Description</label>
            <textarea wire:model="video_description" rows="3" class="text-black w-full p-2 border rounded"></textarea>
        </div>

        <div>
            <label class="font-bold text-black">YouTube Video Link <span class="text-red-600">*</span></label>
            <input type="text" wire:model="video_link" class="text-black w-full p-2 border rounded">
            @error('video_link') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-bold text-black">Thumbnail Image</label>
            <input type="file" wire:model="thumbnail" class="text-black w-full p-2 border rounded">
            @if ($thumbnail && is_object($thumbnail))
                <img src="{{ $thumbnail->temporaryUrl() }}" class="h-20 my-2 rounded border">
            @elseif ($existing_thumbnail)
                <img src="{{ asset('storage/' . $existing_thumbnail) }}" class="h-20 my-2 rounded border">
            @endif
            @error('thumbnail') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" wire:model="status" id="status" class="text-black">
            <label for="status" class="text-black">Active</label>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Save Video
        </button>
    </form>
</div>
