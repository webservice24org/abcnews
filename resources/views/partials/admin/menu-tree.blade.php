@foreach ($menus as $menu)
    <tr class="{{ $level > 0 ? 'bg-yellow-100' : '' }}">
    <td class="pl-{{ $level * 6 }} text-black border px-4 py-2">
        {{ $menu->title }}
    </td>
    <td class="text-black border px-4 py-2">{{ $menu->type }}</td>
    <td class="text-black border px-4 py-2">{{ $menu->order }}</td>
    <td class="border px-4 py-2">
        <button wire:click="showSubmenuForm({{ $menu->id }})" class="text-white bg-amber-600 py-1 px-1 hover:underline rounded">➕ Submenu</button>
        <button wire:click="editMenu({{ $menu->id }})" class="text-white bg-blue-600 py-1 px-1 hover:underline ml-2 rounded">✏️ Edit</button>
        <button wire:click="removeMenu({{ $menu->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="text-white bg-red-600 py-1 px-1 rounded hover:underline ml-2">🗑 Delete</button>
    </td>

</tr>


    {{-- Submenu form --}}
    @if($parentIdForSubmenu === $menu->id)
        <tr>
            <td colspan="4" class="pl-{{ ($level + 1) * 6 }} border px-4 py-2">
                <form wire:submit.prevent="createSubmenu" class="space-x-2">
                    <input type="text" wire:model.defer="newTitle" placeholder="Submenu title" class="border px-2 py-1 rounded text-black" />
                    <select wire:model.defer="newType" class="border px-2 py-1 rounded text-black">
                        <option value="">Select Type</option>
                        <option value="category">Category</option>
                        <option value="subcategory">Subcategory</option>
                        <option value="division">Division</option>
                        <option value="custom">Custom</option>
                    </select>
                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Save</button>
                </form>
            </td>
        </tr>
    @endif

    @php
        $editingMenuId = $editingMenuId ?? null;
    @endphp

@if($editingMenuId === $menu->id)
<tr>
    <td colspan="4" class="pl-{{ $level * 6 }} border px-4 py-2 bg-gray-50">
        <form wire:submit.prevent="updateMenu" class="space-x-2">
            <input type="text" wire:model.defer="editTitle" class="border px-2 py-1 rounded text-black" placeholder="Title" />
            <select wire:model.defer="editType" class="border px-2 py-1 rounded text-black">
                <option value="category">Category</option>
                <option value="subcategory">Subcategory</option>
                <option value="division">Division</option>
                <option value="custom">Custom</option>
            </select>
            <input type="number" wire:model.defer="editOrder" class="border px-2 py-1 rounded text-black w-24" placeholder="Order" />
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Update</button>
        </form>
    </td>
</tr>
@endif



    {{-- Recursively show children --}}
    @if ($menu->children->count())
        @include('partials.admin.menu-tree', ['menus' => $menu->children, 'level' => $level + 1, 'editingMenuId' => $editingMenuId])

    @endif
@endforeach
