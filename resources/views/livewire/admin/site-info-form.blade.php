
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 border-b-2 bg-amber-100 p-2 text-black">Website's basic informations</h2>

    <form wire:submit.prevent="save" class="space-y-4">

        <div>
            <label class="block font-bold text-black">Site Name</label>
            <input type="text" wire:model.defer="site_name" class="w-full border p-2 rounded text-black">
        </div>

        <div>
            <label class="block font-bold text-black">Tagline</label>
            <input type="text" wire:model.defer="tagline" class="w-full border p-2 rounded text-black">
        </div>

        <div>
            <label class="block font-bold text-black">Meta Tags</label>
            <textarea wire:model.defer="meta_tags" rows="3" class="w-full border p-2 rounded text-black"></textarea>
        </div>

        <div>
            <label class="block font-bold text-black">Meta Description</label>
            <textarea wire:model.defer="meta_description" rows="3" class="w-full border p-2 rounded text-black"></textarea>
        </div>

        <div>
            <label class="block font-bold text-black">Copyright Info</label>
            <input type="text" wire:model="copyright_info"
                class="text-black border p-2 rounded w-full"
                placeholder="e.g., © {{ date('Y') }} MicroWeb Technology. All rights reserved.">
        </div>


        <div>
            <label class="block font-bold text-black">Fallback Site Image</label>
            

            <input type="file" wire:model="site_image" class="w-full border p-2 rounded text-black">
            @if ($siteInfo->site_image && !is_object($site_image))
                <img src="{{ asset('storage/' . $siteInfo->site_image) }}" class="h-16 my-2">
            @elseif ($site_image && is_object($site_image))
                <img src="{{ $site_image->temporaryUrl() }}" class="h-16 my-2 border rounded">
            @endif
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Save Info
        </button>
    </form>
</div>

@push('scripts')
    <script>

        window.Livewire.on('toast', ({ type, message }) => {
            showToast(type, message);
        });
    </script>
@endpush