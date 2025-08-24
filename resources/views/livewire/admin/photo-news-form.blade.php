<div class="p-4 bg-white shadow rounded">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Create Photo News</h2>

    <form wire:submit.prevent="{{ $photoNewsId ? 'updateOrCreate' : 'save' }}">



        <div class="mb-4">
            <label class="block font-semibold mb-1 text-black">Title</label>
            <input wire:model="title" type="text" class="w-full border px-3 py-2 rounded text-black" required>
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1 text-black">Description</label>
            <textarea wire:model="description" class="w-full border px-3 py-2 rounded text-black"></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1 text-black">Main Thumbnail</label>
            <input type="file" wire:model="main_thumbnail" class="w-full text-black p-1 rounded border">
            @if ($main_thumbnail)
                <img src="{{ $main_thumbnail->temporaryUrl() }}" class="h-20 mt-2 rounded border">
            @endif
            @if ($existingThumbnail && !$main_thumbnail)
                <img src="{{ asset('storage/' . $existingThumbnail) }}" class="h-24 mb-2">
            @endif

            @error('main_thumbnail') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2 text-black">Photo Gallery</label>

            @foreach ($imageInputs as $index)
                <div class="mb-4 p-3 border rounded relative bg-gray-50">
                    <button type="button" wire:click="removeImageInput({{ $index }})"
                        class="absolute top-1 right-2 text-red-600 text-sm">Remove</button>

                    {{-- Newly uploaded (not saved yet) --}}
                    <input type="file" wire:model="photos.{{ $index }}" class="w-full mb-2 text-black border px-2 py-1">
                    @if (!empty($photos[$index]))
                        <img src="{{ $photos[$index]->temporaryUrl() }}" class="h-20 mb-2 border rounded">
                    @endif

                    {{-- Already saved images --}}
                    @if (!empty($images[$index]) && !is_object($images[$index]))
                        <div class="relative">
                            <img src="{{ asset('storage/' . $images[$index]) }}" class="h-20 mb-2 border rounded">
                            <button type="button" wire:click="deleteSavedImage({{ $index }})"
                                class="absolute top-1 right-1 bg-red-600 text-white px-2 py-1 text-xs rounded hover:bg-red-700">
                                Delete
                            </button>
                        </div>
                    @endif

                    <input type="text" wire:model="captions.{{ $index }}" class="w-full border px-2 py-1 text-black" placeholder="Caption (optional)">
                </div>
            @endforeach




            <button type="button" wire:click="addImageInput"
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">+ Add Photo</button>

                

        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1 text-black">Status</label>
            <select wire:model="status" class="w-full border px-3 py-2 rounded text-black">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>

        <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">Save</button>
    </form>
</div>
