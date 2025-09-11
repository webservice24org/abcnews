<div class="p-6 bg-white rounded shadow space-y-6">
    <h2 class="text-xl text-black font-semibold mb-4">Homepage Lead Section</h2>

    {{-- Enable/Disable Lead Section --}}
    <div class="mb-4">
        <label class="flex items-center space-x-2">
            <input type="checkbox" wire:model="enabled" class="rounded">
            <span class="text-black">Enable Lead Section</span>
        </label>
    </div>

    {{-- Lead Section Design Options --}}
    <div class="grid grid-cols-3 gap-6">
        @foreach($designOptions as $key => $opt)
            <div 
                class="border rounded-lg overflow-hidden cursor-pointer transition hover:shadow-lg 
                       {{ $design === $key ? 'border-blue-500 ring-2 ring-blue-400' : '' }}"
                wire:click="$set('design', '{{ $key }}')"
            >
                <img src="{{ $opt['preview'] }}" 
                     alt="{{ $opt['label'] }}" 
                     class="w-full h-32 object-cover mb-2">
                <p class="text-center text-black font-medium px-2 pb-2">{{ $opt['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Save Button --}}
    <button wire:click="save" 
        class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
        Save Changes
    </button>
</div>

