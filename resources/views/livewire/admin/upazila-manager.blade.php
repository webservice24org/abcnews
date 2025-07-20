<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 text-black">Upazila Manager</h2>

    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <form wire:submit.prevent="{{ $editingUpazilaId ? 'updateUpazila' : 'saveUpazila' }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-center">
            <select wire:model="{{ $editingUpazilaId ? 'editingDistrictId' : 'district_id' }}"
                    class="text-black w-full border p-2 rounded">
                <option value="">Select District</option>
                @foreach($districts as $dist)
                    <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                @endforeach
            </select>

            <input wire:model="{{ $editingUpazilaId ? 'editingName' : 'name' }}"
                   type="text"
                   placeholder="Upazila Name"
                   class="text-black w-full border p-2 rounded" />

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-{{ $editingUpazilaId ? 'green' : 'blue' }}-600 text-white px-4 py-2 rounded w-full">
                    {{ $editingUpazilaId ? 'Update' : 'Add' }}
                </button>

                @if($editingUpazilaId)
                    <button type="button"
                            wire:click="$set('editingUpazilaId', null)"
                            class="bg-gray-500 text-white px-4 py-2 rounded w-full">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    @endif

    <table class="w-full border border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left text-black">District</th>
                <th class="border px-4 py-2 text-left text-black">Upazila</th>
                <th class="border px-4 py-2 text-left text-black">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($upazilas as $upa)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-black">{{ $upa->district->name }}</td>
                    <td class="border px-4 py-2 text-black">{{ $upa->name }}</td>
                    <td class="border px-4 py-2">
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <button wire:click="editUpazila({{ $upa->id }})" class="text-white mr-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-60 rounded text-sm">Edit</button>
                            <button wire:click="confirmDeleteUpazila({{ $upa->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Delete</button>
                        @else
                            <span class="text-gray-400">Read Only</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $upazilas->links() }}
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
