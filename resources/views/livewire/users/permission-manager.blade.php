<div class="container mx-auto py-4 px-4">
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">{{ __('Permission Manager') }}</h2>
        </div>

        <div class="p-6 space-y-4">
            @if (auth()->check() && auth()->user()->hasAnyRole(['Super Admin']))
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
                <div>
                    <input type="text" wire:model="name"
                           class="w-full px-4 py-2 text-black border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                           placeholder="Permission name">
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit"
                            class="px-4 py-2 rounded text-white {{ $isEdit ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}">
                        {{ $isEdit ? 'Update Permission' : 'Add Permission' }}
                    </button>

                    @if($isEdit)
                        <button type="button"
                                wire:click="resetForm"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
            
            <hr class="border-t border-gray-300" />
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2 text-black border border-gray-300">Permission</th>
                            <th class="px-4 py-2 text-black border border-gray-300" width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-black border border-gray-300">{{ $permission->name }}</td>
                                 @if (auth()->check() && auth()->user()->hasAnyRole(['Super Admin']))
                                <td class="px-4 py-2 border border-gray-300 space-x-2">
                                    <button wire:click="edit({{ $permission->id }})"
                                            class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $permission->id }})"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                                        Delete
                                    </button>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4">
                {{ $permissions->links() }} 
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.Livewire.on('confirm-delete', (id) => confirmDelete('deleteConfirmed', id));
    window.Livewire.on('toast', ({ type, message }) => showToast(type, message));
</script>
@endpush
