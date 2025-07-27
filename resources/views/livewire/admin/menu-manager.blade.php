<div class="flex gap-6">

    {{-- Left column: Categories, Subcategories, Divisions --}}
    <div class="w-1/3 p-4 bg-white rounded shadow space-y-6">
        {{-- Custom Menu Section --}}
        <div class="border rounded p-4">
            <h3 class="font-semibold mb-2 text-black">➕ Add Custom Parent Menu</h3>
            <form wire:submit.prevent="addCustomMenu" class="space-y-2">
                <input type="text" wire:model.defer="customMenuTitle" placeholder="Custom menu name" class="border px-2 py-1 rounded w-full text-black" />
                <button type="submit" class="bg-black text-white px-4 py-1 rounded hover:bg-gray-800 w-full">
                    Add Custom Menu
                </button>
            </form>
        </div>

        <div class="border rounded p-4">
            <h3 class="font-semibold mb-2 text-black">Categories & Subcategories</h3>
            <div class="max-h-64 overflow-y-auto">
                @foreach($categories as $category)
                    <div class="mb-2">
                        <label class="inline-flex items-center text-black">
                            <input type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}" class="mr-2">
                            {{ $category->name }}
                        </label>

                        {{-- Subcategories --}}
                        @if($category->subcategories->count())
                            <div class="pl-6 mt-1">
                                @foreach($category->subcategories as $subcategory)
                                    <label class="inline-flex items-center mb-1 text-black">
                                        <input type="checkbox" wire:model="selectedSubCategories" value="{{ $subcategory->id }}" class="mr-2">
                                        {{ $subcategory->name }} {{ $subcategory->slug }} 
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="border rounded p-4">
            <h3 class="font-semibold mb-2 text-black">Divisions</h3>
            <div class="max-h-64 overflow-y-auto">
                @foreach($divisions as $division)
                    <label class="inline-flex items-center mb-2 text-black">
                        <input type="checkbox" wire:model="selectedDivisions" value="{{ $division->id }}" class="mr-2">
                        {{ $division->name }} {{$division->slug}}
                    </label>
                @endforeach
            </div>
        </div>

        <button wire:click="addToMenu" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
            Add to Menu
        </button>

    </div>

    {{-- Right column: Menu Items with drag-and-drop --}}
    <div class="w-2/3 p-4 bg-white rounded shadow">
    


    <h2 class="text-2xl font-bold mb-4">Menu Manager</h2>

    <table class="w-full table-auto border border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left px-2 py-1 border text-black">Title</th>
                <th class="text-left px-2 py-1 border text-black">Type</th>
                <th class="text-left px-2 py-1 border text-black">Order</th>
                <th class="text-left px-2 py-1 border text-black">Slug</th>
                <th class="text-left px-2 py-1 border text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            @include('partials.admin.menu-tree', ['menus' => $menuTree, 'level' => 0])
        </tbody>
    </table>







</div>


</div>








