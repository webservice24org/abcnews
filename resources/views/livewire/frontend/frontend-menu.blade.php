
<header class="bg-red-600 h-[50px] md:h-[100px] sticky top-0 z-50"
        x-data="{ open: false, showSearch: false, showSlideMenu: false }">

    <nav class="max-w-7xl mx-auto border-b border-gray-200 w-full h-full">
        <div class="px-4 flex justify-between items-center h-full">

            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    @if (!empty($siteSetting) && $siteSetting->header_logo)
                        <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Logo" class="h-10 md:h-15 object-contain">
                    @else
                        <img src="{{ asset('storage/logos/front-real-logo.png') }}" alt="Logo" class="h-10 md:h-15 object-contain">
                    @endif
                </a>
            </div>


            <div class="flex">
                <button @click="open = !open" class="md:hidden p-2 mr-2 text-white focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <button @click="showSearch = !showSearch"
                    class="md:hidden inline-flex items-center justify-center mt-2 w-8 h-8 text-white hover:text-yellow-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                    </svg>
                </button>
            </div>

            <div class="hidden md:flex overflow-x-auto md:overflow-visible">
                <nav class="flex space-x-3 md:space-x-3 whitespace-nowrap front-navbar">
                    @foreach ($menuTree as $menu)
                        @php
                            switch ($menu->type) {
                                case 'category':
                                    $url = $menu->slug ? route('category.show', $menu->slug) : '#';
                                    break;
                                case 'subcategory':
                                    $url = $menu->slug ? route('subcategory.show', $menu->slug) : '#';
                                    break;
                                case 'division':
                                    $url = $menu->slug ? route('division.show', $menu->slug) : '#';
                                    break;
                                case 'custom':
                                    $url = $menu->slug ?: '#'; // use slug as full URL
                                    break;
                                default:
                                    $url = '#';
                            }
                        @endphp

                        <div class="relative group shrink-0 {{ !$loop->last ? 'border-r border-white pr-2' : '' }}">
                            <a href="{{ $url ?? '#' }}" class="flex items-center px-1 py-1 text-white hover:text-gray-100 font-medium">
                                {{ $menu->title }}
                                @if ($menu->children->count())
                                    <svg class="ml-1 w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.21l3.71-3.98a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>

                            {{-- Dropdown for child menus --}}
                            @php $children = $menu->children ?? collect(); @endphp
                            @if ($children->isNotEmpty())
                                <div class="absolute left-0 hidden group-hover:block bg-white border border-gray-200 rounded shadow-lg min-w-[160px] z-50">
                                    @foreach ($children as $child)
                                       @php
                                            switch ($child->type) {
                                                case 'category':
                                                    $childUrl = $child->slug ? route('category.show', $child->slug) : '#';
                                                    break;
                                                case 'subcategory':
                                                    $childUrl = $child->slug ? route('subcategory.show', $child->slug) : '#';
                                                    break;
                                                case 'division':
                                                    $childUrl = $child->slug ? route('division.show', $child->slug) : '#';
                                                    break;
                                                case 'custom':
                                                    $childUrl = $child->slug ?: '#'; // Custom URL or #
                                                    break;
                                                default:
                                                    $childUrl = '#';
                                            }
                                        @endphp

                                        <a href="{{ $childUrl }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Slide Menu Icon (Desktop only) -->
                    <button @click="showSlideMenu = !showSlideMenu"
                        class="hidden md:inline-flex items-center justify-center w-10 h-10 text-white hover:text-yellow-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>

                    <!-- Search Icon (Both desktop and mobile) -->
                    <button @click="showSearch = !showSearch"
                        class="inline-flex items-center justify-center w-10 h-10 text-white hover:text-yellow-300 transition md:ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                        </svg>
                    </button>

                    
                </nav>
                

            </div>
        </div>

        <div :class="{ 'block': open, 'hidden': !open }" class="bg-white md:hidden px-4 pb-4 space-y-2">
            @foreach ($menuTree as $menu)
                @php $hasChildren = $menu->children->isNotEmpty(); @endphp
                <div x-data="{ openDropdown: false }">
                    <button 
                        @click="openDropdown = !openDropdown" 
                        class="flex justify-between w-full text-black font-medium py-2 border-b border-gray-300 focus:outline-none"
                    >
                        <a href="{{ $url ?? '#' }}">{{ $menu->title }}</a>
                        @if ($hasChildren)
                            <svg :class="{ 'rotate-180': openDropdown }" class="w-4 h-4 transform transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.21l3.71-3.98a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </button>

                    @if ($hasChildren)
                        <div x-show="openDropdown" x-transition class="pl-4 space-y-1 mt-1">
                            @foreach ($menu->children as $child)
                                <a  href="{{ $childUrl }}" class="block text-sm text-gray-700 py-1 hover:underline">
                                    - {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </nav>

    <!-- Toggleable Search Form -->
<div x-show="showSearch" x-transition class="bg-white px-4 py-3 relative">
    <form action="{{ route('search') }}" method="GET" class="max-w-xl mx-auto flex relative">
        <input type="text" name="q" id="searchInput" autocomplete="off"
            placeholder="Search posts..."
            class="w-full border border-gray-300 rounded-l px-3 py-2 focus:outline-none text-black">

        <button type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded-r hover:bg-red-700">
            Search
        </button>
    </form>
</div>


    <!-- Desktop Slide Menu (right side) -->
    <div x-show="showSlideMenu" x-transition
        class="hidden md:block fixed top-0 right-0 w-80 h-full bg-white shadow-lg z-50 p-5 text-black overflow-y-auto">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <div>
                <a href="{{ route('login') }}" class="text-sm underline">Login</a> / 
                <a href="#" class="text-sm underline">Sign Up</a>
            </div>

            <button @click="showSlideMenu = false" class="text-gray-500 hover:text-red-600">
                ✕
            </button>
            
        </div>
        <div class="search-form bg-white px-4 py-3">
            <form action="{{ route('search') }}" method="GET" class="max-w-xl mx-auto flex relative">
                <input type="text" name="q" id="searchInput" autocomplete="off"
                    placeholder="Search posts..."
                    class="w-full border border-gray-300 rounded-l px-3 py-2 focus:outline-none text-black">

                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-r hover:bg-red-700">
                    Search
                </button>
            </form>
        </div>

        <!-- Icons -->
        <div class="flex justify-around py-4 border-b border-black text-center">
            <div>
                <span class="text-xl">🎥</span>
                <p class="text-xs">WATCH</p>
            </div>
            <div>
                <span class="text-xl">🔊</span>
                <p class="text-xs">LISTEN</p>
            </div>
            <div>
                <span class="text-xl">🗂️</span>
                <p class="text-xs">PLAY</p>
            </div>
        </div>
        
        <nav class="flex flex-col space-y-3 p-4">
            @foreach ($menuTree as $menu)
                @php $hasChildren = $menu->children->isNotEmpty(); @endphp
                <div x-data="{ openDropdown: false }">
                    <button 
                        @click="openDropdown = !openDropdown" 
                        class="flex justify-between w-full text-black font-medium py-2 border-b border-gray-300 focus:outline-none"
                    >
                        <a href="{{ $url ?? '#' }}">{{ $menu->title }}</a>
                        @if ($hasChildren)
                            <svg :class="{ 'rotate-180': openDropdown }" class="w-4 h-4 transform transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.21l3.71-3.98a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </button>

                    @if ($hasChildren)
                        <div x-show="openDropdown" x-transition class="pl-4 space-y-1 mt-1">
                            @foreach ($menu->children as $child)
                                <a  href="{{ $childUrl }}" class="block text-sm text-gray-700 py-1 hover:underline">
                                    - {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        <button type="submit" class="bg-red-600 hover:bg-black text-white px-4 py-2 rounded">
            Become a Member
        </button>
        <div class="mt-4">
            <livewire:frontend.social-icons />
        </div>
    </div>
</header>

