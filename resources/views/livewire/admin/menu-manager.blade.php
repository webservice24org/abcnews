<div class="flex gap-6">

    {{-- Left column: Categories, Subcategories, Divisions --}}
    <div class="w-1/3 p-4 bg-white rounded shadow space-y-6">

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
                                        {{ $subcategory->name }}
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
                        {{ $division->name }}
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
    <h3 class="font-semibold mb-4 text-black">Menu Items (Drag and Drop to reorder)</h3>

    <ul id="menu-list">
    @foreach ($menuItems as $menu)
        <li data-id="{{ $menu->id }}" class="mb-2 border p-2 rounded bg-gray-100">
            <div class="flex justify-between items-center">
                <span class="handle cursor-move text-black">{{ $menu->title }}</span>
                <button wire:click="removeMenu({{ $menu->id }})" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
            </div>

            @if ($menu->children->count())
                <ul>
                    @foreach ($menu->children as $child)
                        <li data-id="{{ $child->id }}" class="ml-6 mt-2 border p-2 rounded bg-gray-50">
                            <div class="flex justify-between items-center">
                                <span class="handle cursor-move text-black">{{ $child->title }}</span>
                                <button wire:click="removeMenu({{ $child->id }})" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>



</div>


</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        let menuList = document.getElementById('menu-list');

        new Sortable(menuList, {
            animation: 150,
            handle: '.handle', // this matches your <span class="handle">
            onEnd: function (evt) {
                let order = serializeMenu(menuList);
                Livewire.emit('updateMenuOrder', order);
            }
        });

        // Initialize sortable on all child ULs (if you want nested drag & drop)
        menuList.querySelectorAll('ul').forEach(function(childUl) {
            new Sortable(childUl, {
                group: 'nested',
                animation: 150,
                handle: '.handle',
                onEnd: function (evt) {
                    let order = serializeMenu(menuList);
                    Livewire.emit('updateMenuOrder', order);
                }
            });
        });
    });

    function serializeMenu(el) {
        let items = [];
        el.querySelectorAll(':scope > li').forEach((li, index) => {
            let item = {
                id: li.getAttribute('data-id'),
                order: index + 1,
                children: []
            };

            let childUl = li.querySelector('ul');
            if (childUl) {
                item.children = serializeMenu(childUl);
            }

            items.push(item);
        });
        return items;
    }
</script>




@endpush




