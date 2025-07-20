<div class="container mx-auto py-4 px-4">
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">{{ __('Role Manager') }}</h2>
        </div>

        <div class="p-6 space-y-4">

            @if (session()->has('success'))
                <div class="bg-green-100 text-green-700 border border-green-300 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
                <div>
                    <input type="text" wire:model="name"
                           class="w-full px-4 py-2 border text-black border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                           placeholder="Role name">
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                @if($isEdit)
                <div class="mb-3">
                    <label class="text-black block text-sm font-semibold mb-2">Permissions</label>

                    
                    <div class="mb-2">
                        <label class="text-black inline-flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox"
                                wire:click="toggleSelectAll"
                                :checked="allPermissionsSelected()"
                                class="rounded border-gray-300">
                            <span class="text-sm">Select All</span>
                        </label>
                    </div>

                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($permissions as $permission)
                            <label class="text-black flex items-center space-x-2">
                                <input type="checkbox"
                                    value="{{ $permission->id }}"
                                    wire:model="selectedPermissions"
                                    class="rounded border-gray-300">
                                <span>{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif


                <div class="flex items-center space-x-2">
                    <button type="submit"
                            class="px-4 py-2 rounded text-white {{ $isEdit ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}">
                        {{ $isEdit ? 'Update Role' : 'Add Role' }}
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

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2 text-black border border-gray-300">Role</th>
                            <th class="px-4 py-2 text-black border border-gray-300">Permissions</th>
                            <th class="px-4 py-2 text-black border border-gray-300 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-black border border-gray-300 w-24">
                                    {{ $role->name }}
                                </td>

                                
                                <td class="px-4 py-2 text-sm border border-gray-300 w-70">
                                    @php
                                        $visiblePermissions = $role->permissions->take(3);
                                        $remainingCount = $role->permissions->count() - $visiblePermissions->count();
                                    @endphp

                                    @if ($role->permissions->count())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($visiblePermissions as $permission)
                                                <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach

                                            @if ($remainingCount > 0)
                                                <span class="inline-block px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded">
                                                    +{{ $remainingCount }} more
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500 italic">No permissions</span>
                                    @endif
                                </td>

                               
                                <td class="px-4 py-2 border border-gray-300 space-x-2 w-24 text-right">
                                    <button wire:click="edit({{ $role->id }})"
                                            class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $role->id }})"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>

        </div>
    </div>
</div>




@push('scripts')
<script>
    window.Livewire.on('confirm-delete', (id) => {
        confirmDelete('deleteConfirmed', id);
    });

    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message);
    });
</script>
@endpush
