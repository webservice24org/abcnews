@foreach ($menus as $menu)
    <tr>
        <td class="pl-{{ $level * 6 }} text-black border px-4 py-2">
            {{ $menu->title }}
        </td>
        <td class="text-black border px-4 py-2">{{ $menu->type }}</td>
        <td class="text-black border px-4 py-2">{{ $menu->order }}</td>
        <td class="border px-4 py-2">
            <button wire:click="showSubmenuForm({{ $menu->id }})" class="text-blue-600 hover:underline">➕ Submenu</button>
            <button wire:click="removeMenu({{ $menu->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="text-red-600 hover:underline ml-2">🗑 Delete</button>
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

    {{-- Recursively show children --}}
    @if ($menu->children->count())
        @include('partials.admin.menu-tree', ['menus' => $menu->children, 'level' => $level + 1])
    @endif
@endforeach
