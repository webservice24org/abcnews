<div class="p-6 bg-white shadow rounded space-y-4">
    <h2 class="text-lg font-semibold mb-4 text-black">Create Advertisement</h2>

    <form wire:submit.prevent="save" class="space-y-4" enctype="multipart/form-data">

        <div>
            <p class="font-bold text-black">Select Add Location <span class="text-red-600">*</span></p>
            <select wire:model="ad_name" class="text-black w-full p-2 border rounded">
                <option value="">-- Select Widget --</option>
                @foreach($widgetOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>

        </div>

        <div>
            <label class="font-bold text-black">Ad Image</label>
            <input type="file" wire:model="ad_image" class="text-black w-full p-2 border rounded">
            @if ($ad_image)
                <img src="{{ $ad_image->temporaryUrl() }}" class="h-20 mt-2 rounded">
            @endif
            @error('ad_image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-bold text-black">Ad Code (optional)</label>
            <textarea wire:model="ad_code" class="w-full p-2 border rounded text-black"></textarea>
        </div>

        <div class="flex items-center gap-4">
            <label class="flex items-center space-x-2 text-black">
                <input type="checkbox" wire:model="is_global">
                <span>Is Global?</span>
            </label>

            <label class="flex items-center space-x-2 text-black">
                <input type="checkbox" wire:model="status">
                <span>Status</span>
            </label>
        </div>

        <div>
            <label class="font-bold text-black">Select Categories</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                @foreach ($categories as $category)
                    <label class="flex items-center space-x-2 text-black">
                        <input type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}">
                        <span class="text-black">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="font-bold text-black">Select Subcategories</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                @foreach ($subcategories as $subCategory)
                    <label class="flex items-center space-x-2 text-black">
                        <input type="checkbox" wire:model="selectedSubCategories" value="{{ $subCategory->id }}">
                        <span>{{ $subCategory->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Save Advertisement
            </button>
        </div>

    </form>
</div>

