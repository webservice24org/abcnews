@foreach ($menus as $menu)
    <tr class="{{ $level > 0 ? 'bg-yellow-100' : '' }}">
        <td class="pl-{{ $level * 6 }} text-black border px-4 py-2">
            {{ $menu->title }}
        </td>
        <td class="text-black border px-4 py-2">{{ $menu->type }}</td>
        <td class="text-black border px-4 py-2">{{ $menu->order }}</td>
        <td class="text-black border px-4 py-2">{{ $menu->slug }}</td>
        <td class="border px-4 py-2">
            @if (is_null($menu->parent_id))
                <button wire:click="showSubmenuForm({{ $menu->id }})" class="text-white bg-amber-600 py-1 px-1 hover:underline rounded">
                    ➕ Submenu
                </button>
            @endif

            <button wire:click="editMenu({{ $menu->id }})" class="text-white bg-blue-600 py-1 px-1 hover:underline ml-2 rounded">
                ✏️ Edit
            </button>
            <button wire:click="removeMenu({{ $menu->id }})"
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                    class="text-white bg-red-600 py-1 px-1 rounded hover:underline ml-2">
                🗑 Delete
            </button>
        </td>
    </tr>



   {{-- Submenu form (Subcategories) --}}
@if($parentIdForSubmenu === $menu->id && $availableSubcategories)
    <tr>
        <td colspan="4" class="pl-{{ ($level + 1) * 6 }} border px-4 py-2">
            <form wire:submit.prevent="createSubmenu" class="space-x-2">
                <select wire:model="selectedSubcategoryId" class="border px-2 py-1 rounded text-black">
                    <option value="">Select Subcategory</option>
                    @foreach($availableSubcategories as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                    Save
                </button>
            </form>
        </td>
    </tr>
@endif

{{-- Submenu form (Categories) --}}
@if($parentIdForSubmenu === $menu->id)
    <tr>
        <td colspan="4" class="pl-{{ ($level + 1) * 6 }} border px-4 py-2">
            <form wire:submit.prevent="createCategorySubmenu" class="space-x-2">
                <select wire:model="selectedCategoryId" class="border px-2 py-1 rounded text-black">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600">
                    Add Category Submenu
                </button>
            </form>
        </td>
    </tr>
@endif




    @php
        $editingMenuId = $editingMenuId ?? null;
    @endphp

@if($editingMenuId === $menu->id)
<tr>
    <td colspan="5" class="pl-{{ $level * 6 }} border px-4 py-2 bg-gray-50">
        <form wire:submit.prevent="updateMenu" class="flex flex-wrap items-center gap-3">
            {{-- Title --}}
            <input type="text"
                   wire:model.defer="editTitle"
                   class="border px-3 py-2 rounded text-black w-40"
                   placeholder="Title" />

            {{-- Type --}}
            <select wire:model.defer="editType"
                    class="border px-3 py-2 rounded text-black w-40">
                <option value="category">Category</option>
                <option value="subcategory">Subcategory</option>
                <option value="division">Division</option>
                <option value="custom">Custom</option>
            </select>

            {{-- Order --}}
            <input type="number"
                   wire:model.defer="editOrder"
                   class="border px-3 py-2 rounded text-black w-24"
                   placeholder="Order" />

            {{-- Slug --}}
            <input type="text"
                   wire:model.defer="editSlug"
                   class="border px-3 py-2 rounded text-black w-64"
                   placeholder="Slug or URL" />

            {{-- Submit --}}
            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Update
            </button>
        </form>
    </td>
</tr>
@endif





    {{-- Recursively show children --}}
    @if ($menu->children->count())
        @include('partials.admin.menu-tree', ['menus' => $menu->children, 'level' => $level + 1, 'editingMenuId' => $editingMenuId])

    @endif
@endforeach
