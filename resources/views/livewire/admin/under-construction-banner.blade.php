<div class="p-6 bg-white rounded shadow">


    <h2 class="text-xl text-black font-bold mb-4">
        {{ $updateMode ? 'Update Banner' : 'Create Banner' }}
    </h2>

    <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="mb-6 text-black space-y-3">
        <div>
            <label>Banner Text:</label>
            <input type="text" wire:model="banner_text" class="border p-1 w-full">
            @error('banner_text') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Start Time:</label>
            <input type="datetime-local" wire:model="start_time" class="border p-1 w-full">
            @error('start_time') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>End Time:</label>
            <input type="datetime-local" wire:model="end_time" class="border p-1 w-full">
            @error('end_time') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Status:</label>
            <select wire:model="status" class="border text-black p-1 w-full">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">
                {{ $updateMode ? 'Update' : 'Create' }}
            </button>
            @if($updateMode)
                <button type="button" wire:click="cancel" class="bg-gray-500 text-white px-4 py-1 rounded">
                    Cancel
                </button>
            @endif
        </div>
    </form>

    <h2 class="text-xl font-bold mb-2 text-black">Existing Banners</h2>

    <table class="w-full border text-black">
        <thead>
            <tr class="border-b">
                <th class="p-2 border">Text</th>
                <th class="p-2 border">Start Time</th>
                <th class="p-2 border">End Time</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $banner)
                <tr class="border">
                    <td class="p-2 border">{{ $banner->banner_text }}</td>
                    <td class="p-2 border">{{ $banner->start_time }}</td>
                    <td class="p-2 border">{{ $banner->end_time }}</td>
                    <td class="p-2 border text-center">
                        <button wire:click="toggleStatus({{ $banner->id }})" 
                                class="px-3 py-1 rounded text-sm
                                    {{ $banner->status ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                            {{ $banner->status ? 'Active' : 'Inactive' }}
                        </button>
                    </td>

                    <td class="p-2 border space-x-2">
                        <button wire:click="edit({{ $banner->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="delete({{ $banner->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
