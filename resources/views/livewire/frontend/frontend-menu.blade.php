@if($theme === 'theme1')
<header 
    class="h-[50px] md:h-[100px] sticky top-0 z-50" 
    style="background-color: {{ $color->header_bg ?? '#ff0000' }};"
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

        <!-- Mobile Dropdown Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="bg-white md:hidden px-4 pb-4 space-y-2">
            @foreach ($menuTree as $menu)
                @php $hasChildren = $menu->children->isNotEmpty(); @endphp
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
                            $url = $menu->slug ?: '#';
                            break;
                        default:
                            $url = '#';
                    }
                @endphp

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
                                        $childUrl = $child->slug ?: '#';
                                        break;
                                    default:
                                        $childUrl = '#';
                                }
                            @endphp


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
        <!-- desktop slide menu Menu Items -->
        <nav class="flex flex-col space-y-3 p-4">
            @foreach ($menuTree as $menu)
                @php $hasChildren = $menu->children->isNotEmpty(); @endphp
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
                            $url = $menu->slug ?: '#';
                            break;
                        default:
                            $url = '#';
                    }
                @endphp

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
                                        $childUrl = $child->slug ?: '#';
                                        break;
                                    default:
                                        $childUrl = '#';
                                }
                            @endphp

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

@elseif($theme === 'theme2')
<header class="max-w-5xl mx-auto sticky top-0 z-50 shadow-sm" x-data="{ open: false, showSearch: false }" x-cloak>

    {{-- Top Row: Desktop Only --}}
    <div class="hidden md:flex h-[70px] md:h-[100px] border-b border-gray-200"
        style="background-color: {{ $color->header_bg ?? '#ff0000' }};"
        x-data="{ showSubscribe: false }" x-cloak>

        <!-- Hamburger Menu Icon (Desktop only) -->
        <div class="flex items-center pl-4">
            <button @click="open = true" class="text-black transition hover:cursor-pointer hover:text-sky-400 focus:outline-none">
                <!-- Icon -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        
        {{-- Date (left) --}}
        <div class="flex-1 flex items-center pl-4">
            <span class="text-md text-black font-bold">
                {{ \App\Helpers\DateHelper::formatBanglaDateTime(now()) }}
            </span>
        </div>


        {{-- Logo (center) --}}
        <div class="flex-1 flex items-center justify-center">
            <a href="{{ route('home') }}">
                @if (!empty($siteSetting) && $siteSetting->header_logo)
                    <img src="{{ asset('storage/' . $siteSetting->header_logo) }}"
                        alt="Logo"
                        class="h-12 md:h-16 object-contain">
                @else
                    <img src="{{ asset('storage/logos/front-real-logo.png') }}"
                        alt="Logo"
                        class="h-12 md:h-16 object-contain">
                @endif
            </a>
        </div>

        {{-- Actions (right) --}}
        <div class="flex-1 flex items-center justify-end pr-4 space-x-4">

            <button @click="showSubscribe = true"
                    class="px-4 py-1 bg-sky-300 text-black font-semibold rounded hover:bg-sky-400 hover:cursor-pointer transition">
                সাবস্ক্রাইব 
            </button>

            <a href="{{ route('login') }}"
            class="px-4 py-1 bg-sky-300 text-black font-semibold rounded hover:bg-sky-400 hover:cursor-pointer transition">
                লগ ইন
            </a>
        </div>

        {{-- Subscribe Modal --}}
        <div x-show="showSubscribe" x-cloak
            class="fixed inset-0 flex items-center justify-center"
            x-transition>
            <div @click.away="showSubscribe = false"
                class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">

                {{-- Close button --}}
                <button @click="showSubscribe = false"
                        class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                    ✕
                </button>

                {{-- Your Livewire Subscribe Form --}}
                <div>
                    @if(session('success'))
                        <div class="text-green-600 mb-4 p-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-3">সাবস্ক্রাইব টু নিউজলেটার</h3>

                    <form wire:submit.prevent="subscribe" class="space-y-3">
                        <!-- Name -->
                        <div>
                            <input type="text" wire:model="name" placeholder="Your Name"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <input type="email" wire:model="email" placeholder="Your Email"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            সাবস্ক্রাইব
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Desktop Nav + Search --}}
    <div class="hidden md:flex bg-white border-b w-full relative">
        <div class="max-w-6xl w-full mx-auto px-4 flex items-center">

            {{-- Center Menu --}}
            <div class="flex-1 flex justify-center">
                <nav
                    x-data="{
                        activeIndex: 0,
                        hoverIndex: null,
                        init() {
                            const links = this.$el.querySelectorAll('.nav-item');
                            const current = '{{ request()->url() }}';
                            let found = -1;
                            links.forEach((a, i) => { if (a.href === current) found = i; });
                            this.activeIndex = found >= 0 ? found : 0;
                            this.$nextTick(() => this.updateBar());
                        },
                        currentIndex() { return this.hoverIndex ?? this.activeIndex; },
                        updateBar() {
                            const links = this.$el.querySelectorAll('.nav-item');
                            const i = this.currentIndex();
                            const bar = this.$refs.bar;
                            if (!links[i]) { bar.style.width = '0px'; return; }
                            const rect = links[i].getBoundingClientRect();
                            const parentRect = this.$el.getBoundingClientRect();
                            bar.style.left = (rect.left - parentRect.left) + 'px';
                            bar.style.width = rect.width + 'px';
                        }
                    }"
                    x-init="init()"
                    x-effect="updateBar()"
                    x-on:mouseleave="hoverIndex = null"
                    x-on:resize.window="updateBar()"
                    class="relative flex items-center space-x-6"
                >
                    {{-- Home --}}
                    <a href="{{ url('/') }}"
                    class="nav-item relative font-bold py-3 no-underline"
                    @mouseenter="hoverIndex = 0"
                    :class="currentIndex() === 0 ? 'text-sky-400' : 'text-gray-800'">
                        Home
                    </a>

                    {{-- Dynamic Menu --}}
                    @foreach ($menuTree as $index => $menu)
                        @php
                            $url = match($menu->type) {
                                'category' => $menu->slug ? route('category.show', $menu->slug) : '#',
                                'subcategory' => $menu->slug ? route('subcategory.show', $menu->slug) : '#',
                                'division' => $menu->slug ? route('division.show', $menu->slug) : '#',
                                'custom' => $menu->slug ?: '#',
                                default => '#',
                            };
                            $children = $menu->children ?? collect();
                        @endphp

                        <div class="relative" x-data="{ open: false, left: 0, top: 0 }"
                            @mouseenter="
                                hoverIndex = {{ $index + 1 }};
                                if ($refs.link) {
                                    const rect = $refs.link.getBoundingClientRect();
                                    left = rect.left + window.scrollX;
                                    top = rect.bottom + window.scrollY;
                                    open = true;
                                }
                            "
                            @mouseleave="open = false">

                            <a href="{{ $url }}"
                            class="nav-item relative font-bold py-3 flex items-center no-underline hover:text-sky-400"
                            x-ref="link"
                            :class="{
                                'text-sky-400': currentIndex() === {{ $index + 1 }},
                                'text-gray-800': currentIndex() !== {{ $index + 1 }}
                            }">
                                {{ $menu->title }}

                                @if($children->isNotEmpty())
                                    <svg class="ml-1 w-4 h-4 transform transition-transform"
                                        :class="open ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.21l3.71-3.98a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>

                            {{-- Dropdown OR Mega Menu --}}
                            @if($children->isNotEmpty())
                                @if($menu->title === 'নিউজ এক্সট্রা')
                                    {{-- Mega Menu --}}
                                    <div x-show="open" x-cloak
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 -translate-y-2"
                                        class="fixed bg-white border border-gray-200 rounded shadow-lg w-full max-w-5xl mx-auto p-6 grid grid-cols-4 gap-3 z-50"
                                        :style="`top: ${top}px; left: 328px`"
                                    >
                                        @foreach($children as $child)
                                            @php
                                                $childUrl = match($child->type) {
                                                    'category' => $child->slug ? route('category.show', $child->slug) : '#',
                                                    'subcategory' => $child->slug ? route('subcategory.show', $child->slug) : '#',
                                                    'division' => $child->slug ? route('division.show', $child->slug) : '#',
                                                    'custom' => $child->slug ?: '#',
                                                    default => '#',
                                                };
                                            @endphp
                                            <div>
                                                <a href="{{ $childUrl }}" class="block font-semibold text-gray-800 mb-2 hover:text-[rgb(179,25,66)] no-underline">
                                                    {{ $child->title }}
                                                </a>

                                                {{-- if child has subchildren, list them --}}
                                                @if($child->children && $child->children->isNotEmpty())
                                                    <ul class="space-y-1">
                                                        @foreach($child->children as $subchild)
                                                            @php
                                                                $subUrl = match($subchild->type) {
                                                                    'category' => $subchild->slug ? route('category.show', $subchild->slug) : '#',
                                                                    'subcategory' => $subchild->slug ? route('subcategory.show', $subchild->slug) : '#',
                                                                    'division' => $subchild->slug ? route('division.show', $subchild->slug) : '#',
                                                                    'custom' => $subchild->slug ?: '#',
                                                                    default => '#',
                                                                };
                                                            @endphp
                                                            <li>
                                                                <a href="{{ $subUrl }}" class="text-sm text-gray-600 hover:text-[rgb(179,25,66)] no-underline">
                                                                    {{ $subchild->title }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    {{-- Normal Dropdown --}}
                                    <div x-show="open" x-cloak
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 -translate-y-2"
                                        class="fixed bg-white border border-gray-200 rounded shadow-lg min-w-[160px] z-50"
                                        :style="`top: ${top}px; left: ${left}px`"
                                    >
                                        @foreach($children as $child)
                                            @php
                                                $childUrl = match($child->type) {
                                                    'category' => $child->slug ? route('category.show', $child->slug) : '#',
                                                    'subcategory' => $child->slug ? route('subcategory.show', $child->slug) : '#',
                                                    'division' => $child->slug ? route('division.show', $child->slug) : '#',
                                                    'custom' => $child->slug ?: '#',
                                                    default => '#',
                                                };
                                            @endphp
                                            <a href="{{ $childUrl }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap no-underline">
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach

                    {{-- Sliding underline --}}
                    <div x-ref="bar"
                        class="absolute bottom-0 h-[2px] bg-sky-400"
                        style="transition: left 0.25s cubic-bezier(0.4,0,0.2,1), width 0.25s cubic-bezier(0.4,0,0.2,1);">
                    </div>
                </nav>
            </div>

            {{-- Search Button --}}
            <div class="flex-shrink-0 ml-4">
                <button @click="showSearch = !showSearch; $nextTick(() => { if (showSearch) $refs.searchInput.focus() })"
                        class="inline-flex items-center justify-center w-10 h-10 text-sky-400 hover:text-[rgb(179,25,66)] hover:cursor-pointer transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>



    {{-- Search Form (desktop only) --}}
    <div x-show="showSearch" x-cloak x-transition
         class="hidden md:block bg-white border-t px-4 py-3 relative">
        <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto flex relative">
            <input x-ref="searchInput" type="text" name="q" autocomplete="off"
                   placeholder="Search posts..."
                   class="w-full border border-gray-300 rounded-l px-3 py-2 focus:outline-none text-black">

            <button type="submit"
                    class="bg-sky-400 text-black px-4 py-2 rounded-r hover:bg-sky-700 hover:cursor-pointer transition">
                Search
            </button>
        </form>
    </div>

    {{-- Mobile Header --}}
    <div class="flex md:hidden justify-between items-center px-4 py-2 border-b border-gray-200"
         style="background-color: {{ $color->header_bg ?? '#ff0000' }};">
        <a href="{{ route('home') }}">
            @if (!empty($siteSetting) && $siteSetting->header_logo)
                <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Logo" class="h-8 object-contain">
            @else
                <img src="{{ asset('storage/logos/front-real-logo.png') }}" alt="Logo" class="h-8 object-contain">
            @endif
        </a>

        <!-- Toggle Button -->
        <button @click="open = !open" class="text-gray-800 focus:outline-none">
            <!-- Hamburger -->
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

            <!-- Close Icon -->
            <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Mobile Nav --}}
    <div class="md:hidden flex bg-white border-b w-full border-gray-200">
        <nav
            x-data="{
                activeIndex: 0,
                hoverIndex: null,
                init() {
                    const links = this.$el.querySelectorAll('.nav-item');
                    const current = '{{ request()->url() }}';
                    let found = -1;
                    links.forEach((a, i) => { if (a.href === current) found = i; });
                    this.activeIndex = found >= 0 ? found : 0;
                    this.$nextTick(() => this.reposition());
                },
                currentIndex() { return this.hoverIndex ?? this.activeIndex; },
                reposition() {
                    const links = this.$el.querySelectorAll('.nav-item');
                    const i = this.currentIndex();
                    const bar = this.$refs.bar;
                    if (!links[i]) { bar.style.width = 0; return; }
                    bar.style.left = links[i].offsetLeft + 'px';
                    bar.style.width = links[i].offsetWidth + 'px';
                }
            }"
            x-init="init()"
            x-effect="reposition()"
            x-on:mouseleave="hoverIndex = null"
            x-on:resize.window="reposition()"
            class="relative flex space-x-3 w-full max-w-5xl mx-auto px-2 overflow-x-auto text-sm"
        >

            {{-- Home --}}
            <a href="{{ url('/') }}"
               class="nav-item relative font-medium py-2 text-gray-800"
               @mouseenter="hoverIndex = 0"
               :class="activeIndex === 0 ? 'text-[rgb(179,25,66)]' : 'hover:text-[rgb(179,25,66)]'">
                Home
            </a>

            {{-- Dynamic Menu --}}
            @foreach ($menuTree as $index => $menu)
                @php
                    $url = match($menu->type) {
                        'category' => $menu->slug ? route('category.show', $menu->slug) : '#',
                        'subcategory' => $menu->slug ? route('subcategory.show', $menu->slug) : '#',
                        'division' => $menu->slug ? route('division.show', $menu->slug) : '#',
                        'custom' => $menu->slug ?: '#',
                        default => '#',
                    };
                @endphp

                <a href="{{ $url }}"
                   class="nav-item relative font-medium py-2 text-gray-800"
                   @mouseenter="hoverIndex = {{ $index + 1 }}"
                   :class="activeIndex === {{ $index + 1 }} ? 'text-[rgb(179,25,66)]' : 'hover:text-[rgb(179,25,66)]'">
                    {{ $menu->title }}
                </a>
            @endforeach

            {{-- Sliding underline --}}
            <div x-ref="bar" class="absolute bottom-0 h-[2px] bg-[rgb(179,25,66)] transition-all duration-300 ease-out"></div>
        </nav>
    </div>

    {{-- Mobile Dropdown --}}
    <div x-show="open" x-cloak class="md:hidden bg-white px-4 pb-4 space-y-2">
        @foreach ($menuTree as $menu)
            @php
                $url = match($menu->type) {
                    'category' => $menu->slug ? route('category.show', $menu->slug) : '#',
                    'subcategory' => $menu->slug ? route('subcategory.show', $menu->slug) : '#',
                    'division' => $menu->slug ? route('division.show', $menu->slug) : '#',
                    'custom' => $menu->slug ?: '#',
                    default => '#',
                };
            @endphp
            <a href="{{ $url }}" class="block text-gray-800 font-medium py-2 border-b hover:bg-gray-100 border-gray-200">
                {{ $menu->title }}
            </a>
        @endforeach
    </div>


     <!-- Sliding Sidebar -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex">

        <!-- Overlay -->
        <div @click="open = false" 
            class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Sidebar -->
        <div x-show="open"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative bg-white w-80 max-w-full h-full shadow-xl overflow-y-auto z-50">

            <!-- Close Button -->
            <button @click="open = false"
                    class="absolute top-3 right-3 text-gray-600 hover:text-red-600 text-2xl font-bold">
                ✕
            </button>

            <!-- Sidebar Menu -->
            <nav class="p-4 space-y-1">
                <a href="{{ url('/') }}"
                class="block text-lg font-semibold text-gray-900 hover:text-sky-400 transition-colors duration-200 py-1">
                    Home
                </a>

                @foreach ($categories as $category)
                    <div x-data="{ openCat: false }" class="space-y-0.5 border-b border-gray-200 pb-1">
                        <!-- Category -->
                        <button @click="openCat = !openCat"
                                class="w-full flex justify-between items-center text-gray-800 font-medium hover:bg-gray-100 rounded px-2 py-1 transition-colors duration-200">
                            <span>{{ $category->name }}</span>
                            @if($category->subcategories->count())
                                <svg :class="{'rotate-180': openCat}" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </button>

                        <!-- Subcategories -->
                        <div x-show="openCat" x-collapse class="pl-4 mt-0.5 space-y-0.5">
                            @foreach ($category->subcategories as $sub)
                                <a href="{{ route('subcategory.show', $sub->slug) }}"
                                class="block text-gray-600 text-sm hover:text-[rgb(179,25,66)] px-2 py-0.5 rounded transition-colors duration-200">
                                    {{ $sub->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>
        </div>
    </div>




</header>




@else
    <header class="sticky top-0 z-50 shadow-sm" x-data="{ open: false, showSearch: false }" x-cloak>

        {{-- Top Row: Desktop Only --}}
        <div class="hidden md:flex h-[70px] md:h-[100px] border-b border-gray-200"
            style="background-color: {{ $color->header_bg ?? '#ff0000' }};"
            x-data="{ showSubscribe: false }" x-cloak>

            {{-- Date (left) --}}
            <div class="flex-1 flex items-center pl-4">
                <span class="text-md text-black font-bold">
                    {{ \App\Helpers\DateHelper::formatBanglaDateTime(now()) }}
                </span>
            </div>


            {{-- Logo (center) --}}
            <div class="flex-1 flex items-center justify-center">
                <a href="{{ route('home') }}">
                    @if (!empty($siteSetting) && $siteSetting->header_logo)
                        <img src="{{ asset('storage/' . $siteSetting->header_logo) }}"
                            alt="Logo"
                            class="h-12 md:h-16 object-contain">
                    @else
                        <img src="{{ asset('storage/logos/front-real-logo.png') }}"
                            alt="Logo"
                            class="h-12 md:h-16 object-contain">
                    @endif
                </a>
            </div>

            {{-- Actions (right) --}}
            <div class="flex-1 flex items-center justify-end pr-4 space-x-4">

                <button @click="showSubscribe = true"
                        class="px-4 py-1 bg-[rgb(179,25,66)] text-white font-semibold rounded hover:bg-black hover:cursor-pointer transition">
                    সাবস্ক্রাইব 
                </button>

                <a href="{{ route('login') }}"
                class="px-4 py-1 bg-[rgb(179,25,66)] text-white font-semibold rounded hover:bg-red-700 transition">
                    লগ ইন
                </a>
            </div>

            {{-- Subscribe Modal --}}
            <div x-show="showSubscribe" x-cloak
                class="fixed inset-0 flex items-center justify-center"
                x-transition>
                <div @click.away="showSubscribe = false"
                    class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">

                    {{-- Close button --}}
                    <button @click="showSubscribe = false"
                            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                        ✕
                    </button>

                    {{-- Your Livewire Subscribe Form --}}
                    <div>
                        @if(session('success'))
                            <div class="text-green-600 mb-4 p-2">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h3 class="text-lg font-semibold mb-3">সাবস্ক্রাইব টু নিউজলেটার</h3>

                        <form wire:submit.prevent="subscribe" class="space-y-3">
                            <!-- Name -->
                            <div>
                                <input type="text" wire:model="name" placeholder="Your Name"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <input type="email" wire:model="email" placeholder="Your Email"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Submit -->
                            <button type="submit"
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                                সাবস্ক্রাইব
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- Desktop Nav + Search --}}
        <div class="hidden md:flex bg-white border-b w-full relative">
            <div class="max-w-6xl w-full mx-auto px-4 flex items-center">

                {{-- Center Menu --}}
                <div class="flex-1 flex justify-center">
                    <nav
                        x-data="{
                            activeIndex: 0,
                            hoverIndex: null,
                            init() {
                                const links = this.$el.querySelectorAll('.nav-item');
                                const current = '{{ request()->url() }}';
                                let found = -1;
                                links.forEach((a, i) => { if (a.href === current) found = i; });
                                this.activeIndex = found >= 0 ? found : 0;
                                this.$nextTick(() => this.updateBar());
                            },
                            currentIndex() { return this.hoverIndex ?? this.activeIndex; },
                            updateBar() {
                                const links = this.$el.querySelectorAll('.nav-item');
                                const i = this.currentIndex();
                                const bar = this.$refs.bar;
                                if (!links[i]) { bar.style.width = '0px'; return; }
                                const rect = links[i].getBoundingClientRect();
                                const parentRect = this.$el.getBoundingClientRect();
                                bar.style.left = (rect.left - parentRect.left) + 'px';
                                bar.style.width = rect.width + 'px';
                            }
                        }"
                        x-init="init()"
                        x-effect="updateBar()"
                        x-on:mouseleave="hoverIndex = null"
                        x-on:resize.window="updateBar()"
                        class="relative flex items-center space-x-6"
                    >
                        {{-- Home --}}
                        <a href="{{ url('/') }}"
                        class="nav-item relative font-bold py-3 no-underline"
                        @mouseenter="hoverIndex = 0"
                        :class="currentIndex() === 0 ? 'text-[rgb(179,25,66)]' : 'text-gray-800'">
                            Home
                        </a>

                        {{-- Dynamic Menu --}}
                        @foreach ($menuTree as $index => $menu)
                            @php
                                $url = match($menu->type) {
                                    'category' => $menu->slug ? route('category.show', $menu->slug) : '#',
                                    'subcategory' => $menu->slug ? route('subcategory.show', $menu->slug) : '#',
                                    'division' => $menu->slug ? route('division.show', $menu->slug) : '#',
                                    'custom' => $menu->slug ?: '#',
                                    default => '#',
                                };
                                $children = $menu->children ?? collect();
                            @endphp

                            <div class="relative" x-data="{ open: false, left: 0, top: 0 }"
                                @mouseenter="
                                    hoverIndex = {{ $index + 1 }};
                                    if ($refs.link) {
                                        const rect = $refs.link.getBoundingClientRect();
                                        left = rect.left + window.scrollX;
                                        top = rect.bottom + window.scrollY;
                                        open = true;
                                    }
                                "
                                @mouseleave="open = false">

                                <a href="{{ $url }}"
                                class="nav-item relative font-bold py-3 flex items-center no-underline hover:text-[rgb(179,25,66)]"
                                x-ref="link"
                                :class="{
                                    'text-[rgb(179,25,66)]': currentIndex() === {{ $index + 1 }},
                                    'text-gray-800': currentIndex() !== {{ $index + 1 }}
                                }">
                                    {{ $menu->title }}

                                    @if($children->isNotEmpty())
                                        <svg class="ml-1 w-4 h-4 transform transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.21l3.71-3.98a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </a>

                                {{-- Dropdown OR Mega Menu --}}
                                @if($children->isNotEmpty())
                                    @if($menu->title === 'নিউজ এক্সট্রা')
                                        {{-- Mega Menu --}}
                                        <div x-show="open" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 -translate-y-2"
                                            class="fixed bg-white border border-gray-200 rounded shadow-lg w-full max-w-5xl mx-auto p-6 grid grid-cols-4 gap-3 z-50"
                                            :style="`top: ${top}px; left: 328px`"
                                        >
                                            @foreach($children as $child)
                                                @php
                                                    $childUrl = match($child->type) {
                                                        'category' => $child->slug ? route('category.show', $child->slug) : '#',
                                                        'subcategory' => $child->slug ? route('subcategory.show', $child->slug) : '#',
                                                        'division' => $child->slug ? route('division.show', $child->slug) : '#',
                                                        'custom' => $child->slug ?: '#',
                                                        default => '#',
                                                    };
                                                @endphp
                                                <div>
                                                    <a href="{{ $childUrl }}" class="block font-semibold text-gray-800 mb-2 hover:text-[rgb(179,25,66)] no-underline">
                                                        {{ $child->title }}
                                                    </a>

                                                    {{-- if child has subchildren, list them --}}
                                                    @if($child->children && $child->children->isNotEmpty())
                                                        <ul class="space-y-1">
                                                            @foreach($child->children as $subchild)
                                                                @php
                                                                    $subUrl = match($subchild->type) {
                                                                        'category' => $subchild->slug ? route('category.show', $subchild->slug) : '#',
                                                                        'subcategory' => $subchild->slug ? route('subcategory.show', $subchild->slug) : '#',
                                                                        'division' => $subchild->slug ? route('division.show', $subchild->slug) : '#',
                                                                        'custom' => $subchild->slug ?: '#',
                                                                        default => '#',
                                                                    };
                                                                @endphp
                                                                <li>
                                                                    <a href="{{ $subUrl }}" class="text-sm text-gray-600 hover:text-[rgb(179,25,66)] no-underline">
                                                                        {{ $subchild->title }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        {{-- Normal Dropdown --}}
                                        <div x-show="open" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 -translate-y-2"
                                            class="fixed bg-white border border-gray-200 rounded shadow-lg min-w-[160px] z-50"
                                            :style="`top: ${top}px; left: ${left}px`"
                                        >
                                            @foreach($children as $child)
                                                @php
                                                    $childUrl = match($child->type) {
                                                        'category' => $child->slug ? route('category.show', $child->slug) : '#',
                                                        'subcategory' => $child->slug ? route('subcategory.show', $child->slug) : '#',
                                                        'division' => $child->slug ? route('division.show', $child->slug) : '#',
                                                        'custom' => $child->slug ?: '#',
                                                        default => '#',
                                                    };
                                                @endphp
                                                <a href="{{ $childUrl }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap no-underline">
                                                    {{ $child->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endforeach

                        {{-- Sliding underline --}}
                        <div x-ref="bar"
                            class="absolute bottom-0 h-[2px] bg-[rgb(179,25,66)]"
                            style="transition: left 0.25s cubic-bezier(0.4,0,0.2,1), width 0.25s cubic-bezier(0.4,0,0.2,1);">
                        </div>
                    </nav>
                </div>

                {{-- Search Button --}}
                <div class="flex-shrink-0 ml-4">
                    <button @click="showSearch = !showSearch; $nextTick(() => { if (showSearch) $refs.searchInput.focus() })"
                            class="inline-flex items-center justify-center w-10 h-10 text-gray-800 hover:text-[rgb(179,25,66)] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>



        {{-- Search Form (desktop only) --}}
        <div x-show="showSearch" x-cloak x-transition
            class="hidden md:block bg-white border-t px-4 py-3 relative">
            <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto flex relative">
                <input x-ref="searchInput" type="text" name="q" autocomplete="off"
                    placeholder="Search posts..."
                    class="w-full border border-gray-300 rounded-l px-3 py-2 focus:outline-none text-black">

                <button type="submit"
                        class="bg-[rgb(179,25,66)] text-white px-4 py-2 rounded-r hover:bg-red-700">
                    Search
                </button>
            </form>
        </div>

        {{-- Mobile Header --}}
        <div class="flex md:hidden justify-between items-center px-4 py-2 border-b border-gray-200"
            style="background-color: {{ $color->header_bg ?? '#ff0000' }};">
            <a href="{{ route('home') }}">
                @if (!empty($siteSetting) && $siteSetting->header_logo)
                    <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Logo" class="h-8 object-contain">
                @else
                    <img src="{{ asset('storage/logos/front-real-logo.png') }}" alt="Logo" class="h-8 object-contain">
                @endif
            </a>

            <!-- Toggle Button -->
            <button @click="open = !open" class="text-gray-800 focus:outline-none">
                <!-- Hamburger -->
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

                <!-- Close Icon -->
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Nav --}}
        <div class="md:hidden flex bg-white border-b w-full border-gray-200">
            <nav
                x-data="{
                    activeIndex: 0,
                    hoverIndex: null,
                    init() {
                        const links = this.$el.querySelectorAll('.nav-item');
                        const current = '{{ request()->url() }}';
                        let found = -1;
                        links.forEach((a, i) => { if (a.href === current) found = i; });
                        this.activeIndex = found >= 0 ? found : 0;
                        this.$nextTick(() => this.reposition());
                    },
                    currentIndex() { return this.hoverIndex ?? this.activeIndex; },
                    reposition() {
                        const links = this.$el.querySelectorAll('.nav-item');
                        const i = this.currentIndex();
                        const bar = this.$refs.bar;
                        if (!links[i]) { bar.style.width = 0; return; }
                        bar.style.left = links[i].offsetLeft + 'px';
                        bar.style.width = links[i].offsetWidth + 'px';
                    }
                }"
                x-init="init()"
                x-effect="reposition()"
                x-on:mouseleave="hoverIndex = null"
                x-on:resize.window="reposition()"
                class="relative flex space-x-3 w-full max-w-5xl mx-auto px-2 overflow-x-auto text-sm"
            >

                {{-- Home --}}
                <a href="{{ url('/') }}"
                class="nav-item relative font-medium py-2 text-gray-800"
                @mouseenter="hoverIndex = 0"
                :class="activeIndex === 0 ? 'text-[rgb(179,25,66)]' : 'hover:text-[rgb(179,25,66)]'">
                    Home
                </a>

                {{-- Dynamic Menu --}}
                @foreach ($menuTree as $index => $menu)
                    @php
                        $url = match($menu->type) {
                            'category' => $menu->slug ? route('category.show', $menu->slug) : '#',
                            'subcategory' => $menu->slug ? route('subcategory.show', $menu->slug) : '#',
                            'division' => $menu->slug ? route('division.show', $menu->slug) : '#',
                            'custom' => $menu->slug ?: '#',
                            default => '#',
                        };
                    @endphp

                    <a href="{{ $url }}"
                    class="nav-item relative font-medium py-2 text-gray-800"
                    @mouseenter="hoverIndex = {{ $index + 1 }}"
                    :class="activeIndex === {{ $index + 1 }} ? 'text-[rgb(179,25,66)]' : 'hover:text-[rgb(179,25,66)]'">
                        {{ $menu->title }}
                    </a>
                @endforeach

                {{-- Sliding underline --}}
                <div x-ref="bar" class="absolute bottom-0 h-[2px] bg-[rgb(179,25,66)] transition-all duration-300 ease-out"></div>
            </nav>
        </div>

        {{-- Mobile Dropdown --}}
        <div x-show="open" x-cloak class="md:hidden bg-white px-4 pb-4 space-y-2">
            @foreach ($menuTree as $menu)
                @php
                    $url = match($menu->type) {
                        'category' => $menu->slug ? route('category.show', $menu->slug) : '#',
                        'subcategory' => $menu->slug ? route('subcategory.show', $menu->slug) : '#',
                        'division' => $menu->slug ? route('division.show', $menu->slug) : '#',
                        'custom' => $menu->slug ?: '#',
                        default => '#',
                    };
                @endphp
                <a href="{{ $url }}" class="block text-gray-800 font-medium py-2 border-b hover:bg-gray-100 border-gray-200">
                    {{ $menu->title }}
                </a>
            @endforeach
        </div>

    </header>
@endif

    