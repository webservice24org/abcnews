<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 border-b-2 bg-amber-100 p-2 text-black">Website Logo Settings</h2>


    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-4">

        <div>
            <label class="block font-bold text-black">Header Logo</label>

            <input type="file" wire:model="header_logo" class="text-black border p-2 rounded w-full">

            @if ($header_logo && is_object($header_logo))
                <img src="{{ $header_logo->temporaryUrl() }}" class="bg-red-100 h-16 my-2 border rounded">
            @elseif ($siteSetting->header_logo)
                <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" class="bg-red-300 h-16 my-2">
            @endif
        </div>

        <div>
            <label class="block font-bold text-black">Footer Logo</label>

            <input type="file" wire:model="footer_logo" class="text-black border p-2 rounded w-full">
            @if ($footer_logo && is_object($footer_logo))
                <img src="{{ $footer_logo->temporaryUrl() }}" class="bg-green-100 h-16 my-2 border rounded">
            @elseif ($siteSetting->footer_logo)
                <img src="{{ asset('storage/' . $siteSetting->footer_logo) }}" class="bg-green-300 h-16 my-2">
            @endif
        </div>

        <div>
            <label class="block font-bold text-black">Favicon</label>

            <input type="file" wire:model="favicon" class="text-black border p-2 rounded w-full">

            @if ($favicon && is_object($favicon))
                <img src="{{ $favicon->temporaryUrl() }}" class="bg-blue-100 h-10 my-2 border rounded">
            @elseif ($siteSetting->favicon)
                <img src="{{ asset('storage/' . $siteSetting->favicon) }}" class="bg-blue-300 h-10 my-2">
            @endif
        </div>

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Save Settings
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