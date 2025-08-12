<div class="space-y-4 p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4 text-black">Theme Color Picker</h2>

    @foreach($colors as $field => $value)
        <div class="flex items-center space-x-4">
            <label class="block font-medium text-black w-48">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
            <input type="color" wire:model="colors.{{ $field }}" class="w-16 h-10 border rounded cursor-pointer" />
            <span class="ml-2 text-black">{{ $colors[$field] }}</span>
        </div>
    @endforeach

    <button wire:click="save" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Save Colors</button>

</div>

@push('scripts')
<script>
document.addEventListener('livewire:load', function () {
    Livewire.on('colorsUpdated', (colors) => {
        const root = document.documentElement;
        Object.keys(colors).forEach(key => {
            root.style.setProperty(`--${key}`, colors[key]);
        });
    });

    
});
</script>
@endpush


