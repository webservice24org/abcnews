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
<header class="sticky top-0 z-50 shadow-sm" x-data="{ open: false }">

 {{-- Top Row: Logo (desktop only) --}}
<div class="hidden md:flex h-[70px] md:h-[100px] border-b border-gray-200 " style="background-color: {{ $color->header_bg ?? '#ff0000' }};">
    <div class="max-w-5xl w-full mx-auto px-4 flex items-center">
        <a href="{{ route('home') }}">
            @if (!empty($siteSetting) && $siteSetting->header_logo)
                <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Logo" class="h-12 md:h-16 object-contain">
            @else
                <img src="{{ asset('storage/logos/front-real-logo.png') }}" alt="Logo" class="h-12 md:h-16 object-contain">
            @endif
        </a>
    </div>
</div>



  <div class="hidden md:flex bg-white border-b w-full relative">
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
        class="relative flex space-x-3 w-full max-w-5xl mx-auto px-4 overflow-x-auto"
    >

        {{-- Home --}}
        <a href="{{ url('/') }}"
           class="nav-item relative font-medium py-3 no-underline"
           @mouseenter="hoverIndex = 0"
           :class="currentIndex() === 0 ? 'text-red-600' : 'text-gray-800'">
            মূলপাতা
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
                 @mouseleave="open = false"
            >
                <a href="{{ $url }}"
                   class="nav-item relative from-neutral-600 font-md py-3 flex items-center no-underline text-gray-800"
                   x-ref="link"
                   :class="currentIndex() === {{ $index + 1 }} ? 'text-red-600' : 'text-gray-800'">
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

                {{-- Dropdown --}}
                <div x-show="open"
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
            </div>
        @endforeach

        {{-- Sliding underline --}}
        <div x-ref="bar"
             class="absolute bottom-0 h-[2px] bg-red-600"
             style="transition: left 0.25s cubic-bezier(0.4,0,0.2,1), width 0.25s cubic-bezier(0.4,0,0.2,1);">
        </div>
    </nav>
</div>





    {{-- Mobile Header --}}
{{-- Mobile Header --}}
<div class="flex md:hidden justify-between items-center px-4 py-2 border-b border-gray-200" style="background-color: {{ $color->header_bg ?? '#ff0000' }};">
    <a href="{{ route('home') }}">
        @if (!empty($siteSetting) && $siteSetting->header_logo)
            <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Logo" class="h-8 object-contain">
        @else
            <img src="{{ asset('storage/logos/front-real-logo.png') }}" alt="Logo" class="h-8 object-contain">
        @endif
    </a>

    <!-- Toggle Button -->
    <button @click="open = !open" class="text-white focus:outline-none">
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
           :class="activeIndex === 0 ? 'text-red-600' : 'hover:text-red-600'">
            মূলপাতা
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
               :class="activeIndex === {{ $index + 1 }} ? 'text-red-600' : 'hover:text-red-600'">
                {{ $menu->title }}
            </a>
        @endforeach

        {{-- Sliding underline --}}
        <div x-ref="bar" class="absolute bottom-0 h-[2px] bg-red-600 transition-all duration-300 ease-out"></div>
    </nav>
</div>

    {{-- Mobile Dropdown --}}
    <div x-show="open" class="md:hidden bg-white px-4 pb-4 space-y-2">
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
            <a href="{{ $url }}" class="block text-gray-800 font-medium py-2 border-b hover:bg-gray-400 border-gray-200">
                {{ $menu->title }}
            </a>
        @endforeach
    </div>

</header>


@else
        <div class="theme3">
            <p>theme three content</p>

        </div>
    @endif