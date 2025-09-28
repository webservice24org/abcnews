<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 bg-amber-200 p-2 text-black">Social Connections</h2>

    <form wire:submit.prevent="save" class="space-y-4">
        @foreach (['facebook', 'twitter', 'pinterest', 'tiktok', 'instagram', 'youtube', 'whatsapp'] as $platform)
            <div>
                <label class="block font-bold capitalize text-black">{{ ucfirst($platform) }} URL</label>
                <input type="text" wire:model="{{ $platform }}" class="text-black border p-2 rounded w-full" placeholder="https://{{ $platform }}.com/your-page">
            </div>
        @endforeach

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Save Social Links
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