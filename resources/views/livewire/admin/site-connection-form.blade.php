<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 border-b-2 bg-amber-100 p-2 text-black">Search Engine Verification Codes</h2>

    <form wire:submit.prevent="save" class="space-y-4">

        @foreach ([
            'google' => 'Google',
            'bing' => 'Bing',
            'baidu' => 'Baidu',
            'pinterest' => 'Pinterest',
            'yandex' => 'Yandex',
        ] as $key => $label)
            <div>
                <label class="block font-bold text-black">{{ $label }} Verification</label>
                <input type="text" wire:model.defer="{{ $key }}_verification" class="text-black border p-2 rounded w-full" placeholder="Enter {{ $label }} verification code">
            </div>
        @endforeach

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Save Codes
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