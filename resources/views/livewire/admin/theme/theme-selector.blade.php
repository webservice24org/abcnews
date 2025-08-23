<div x-data="{ previewTheme: @entangle('previewTheme') }" class="space-y-6">
    <h1 class="text-2xl font-bold">Select Theme</h1>

    <div class="grid grid-cols-3 gap-6">
        @foreach($themes as $theme)
            @php
                $isSelected = $previewTheme === $theme['id'] || ($previewTheme === null && $activeTheme === $theme['id']);
            @endphp

            <div class="border rounded-lg shadow p-2 text-center 
                        @if($isSelected) ring-2 ring-blue-500 @endif">
                
                <img src="{{ $theme['thumbnail'] }}" 
                     alt="{{ $theme['name'] }}" 
                     class="w-full h-40 object-cover rounded">

                <h2 class="mt-2 font-semibold">{{ $theme['name'] }}</h2>

                <div class="flex justify-center gap-2 mt-3">
                    <button wire:click="preview('{{ $theme['id'] }}')"
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-black hover:cursor-pointer">
                        Preview
                    </button>

                    @if($previewTheme === $theme['id'])
                        <button wire:click="save"
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 hover:cursor-pointer">
                            Activate
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Show current preview & active theme --}}
    <div class="mt-8 p-6 border rounded bg-gray-50">
        <p class="text-black">Currently previewing: <strong>{{ $previewTheme }}</strong></p>
        <p class="text-black">Active theme: <strong>{{ $activeTheme }}</strong></p>
    </div>
</div>



@push('scripts')
<script>
    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message); 
    });
</script>
@endpush