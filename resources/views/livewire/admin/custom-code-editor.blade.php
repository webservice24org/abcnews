<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4 text-black">Custom CSS and JavaScript Editor</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <div>
            <label for="custom_css" class="block font-medium text-gray-700 mb-1">Custom CSS</label>
            <textarea id="custom_css" rows="8" wire:model.defer="custom_css" class="text-black w-full border rounded p-2 font-mono text-sm" placeholder="Add your custom CSS here..."></textarea>
        </div>

        <div>
            <label for="custom_js" class="block font-medium text-gray-700 mb-1">Custom JavaScript</label>
            <textarea id="custom_js" rows="8" wire:model.defer="custom_js" class="text-black w-full border rounded p-2 font-mono text-sm" placeholder="Add your custom JavaScript here..."></textarea>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
    </form>
</div>
