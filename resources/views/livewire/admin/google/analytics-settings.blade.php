<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Google Analytics Settings</h2>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Analytics Property ID</label>
        <input type="text" wire:model="property_id"
               class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Service Account JSON</label>
        <textarea wire:model="service_account_json" rows="10"
                  class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"></textarea>
    </div>

    <button wire:click="save"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
        Save Settings
    </button>
</div>

@push('scripts')
<script>
    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message); 
    });
</script>
@endpush