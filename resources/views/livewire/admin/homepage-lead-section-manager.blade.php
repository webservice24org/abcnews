<div class="p-6 bg-white rounded shadow space-y-6">
    <h2 class="text-xl text-black font-semibold mb-4">Homepage Lead Section</h2>

    <div class="mb-4">
        <label class="flex items-center space-x-2">
            <input type="checkbox" wire:model="enabled" class="rounded">
            <span class="text-black">Enable Lead Section</span>
        </label>
    </div>

    <div class="grid grid-cols-2 gap-6">
        @foreach($designOptions as $key => $opt)
            <div 
                class="border rounded-lg p-3 cursor-pointer transition hover:shadow-lg 
                       {{ $design === $key ? 'border-blue-500 ring-2 ring-blue-400' : '' }}"
                wire:click="$set('design', '{{ $key }}')"
            >
                <img src="{{ $opt['preview'] }}" alt="{{ $opt['label'] }}" class="rounded mb-2">
                <p class="text-center text-black font-medium">{{ $opt['label'] }}</p>
            </div>
        @endforeach
    </div>

    <button wire:click="save" 
        class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Save Changes
    </button>
</div>
