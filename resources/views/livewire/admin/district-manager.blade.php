<div class="p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4 text-black">District Manager</h2>

    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <form wire:submit.prevent="{{ $editingDistrictId ? 'updateDistrict' : 'saveDistrict' }}"
            class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-center">

            {{-- Column 1: Division Dropdown --}}
            <select wire:model="{{ $editingDistrictId ? 'editingDivisionId' : 'division_id' }}"
                    class="text-black w-full border p-2 rounded">
                <option value="">Select Division</option>
                @foreach($divisions as $div)
                    <option value="{{ $div->id }}">{{ $div->name }}</option>
                @endforeach
            </select>

            {{-- Column 2: District Name Input --}}
            <input wire:model="{{ $editingDistrictId ? 'editingName' : 'name' }}"
                type="text"
                placeholder="District Name"
                class="text-black w-full border p-2 rounded" />

            {{-- Column 3: Buttons --}}
            <div class="flex gap-2">
                <button type="submit"
                        class="bg-{{ $editingDistrictId ? 'green' : 'blue' }}-600 text-white px-4 py-2 rounded w-full">
                    {{ $editingDistrictId ? 'Update' : 'Add' }}
                </button>

                @if($editingDistrictId)
                    <button type="button"
                            wire:click="$set('editingDistrictId', null)"
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
                <th class="border px-4 py-2 text-left text-black">Sl</th>
                <th class="border px-4 py-2 text-left text-black">Division</th>
                <th class="border px-4 py-2 text-left text-black">District</th>
                <th class="border px-4 py-2 text-left text-black">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($districts as $district)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-black">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2 text-black">{{ $district->division->name }}</td>
                    <td class="border px-4 py-2 text-black">{{ $district->name }}</td>
                    <td class="border px-4 py-2">
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <button wire:click="editDistrict({{ $district->id }})" class="text-white mr-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-60 rounded text-sm">Edit</button>
                            <button wire:click="confirmDeleteDistrict({{ $district->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Delete</button>
                        @else
                            <span class="text-gray-400">Read Only</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $districts->links() }}
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

