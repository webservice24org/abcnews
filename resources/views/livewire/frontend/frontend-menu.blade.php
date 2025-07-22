<header class="bg-red-600 h-[100px] relative sticky top-0 z-50" x-data="{ open: false }">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-12 items-center">
            <!-- Logo -->
            <div class="col-span-12 md:col-span-3 flex justify-center md:justify-start mb-4 md:mb-0">
                <img src="{{ asset('storage/logos/front-logo.png') }}" alt="Logo" class="front-logo object-contain">
            </div>

            <!-- Menu -->
            <div class="col-span-12 md:col-span-9 overflow-x-auto md:overflow-visible">
                <nav class="flex space-x-4 md:space-x-6 whitespace-nowrap front-navbar">
                    @foreach ($menuTree as $menu)
                        <div class="relative group shrink-0">
                            <a href="#" class="flex items-center px-2 py-2 text-black bg-white hover:bg-gray-100 font-medium rounded">
                                {{ $menu->title }}
                                @if ($menu->children->count())
                                    <svg class="ml-1 w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.21l3.71-3.98a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>

                            @php $children = $menu->children ?? collect(); @endphp
                            @if ($children->isNotEmpty())
                                <div class="absolute left-0 hidden group-hover:block bg-white border border-gray-200 rounded shadow-lg min-w-[160px] z-50">
                                    @foreach ($children as $child)
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</header>
