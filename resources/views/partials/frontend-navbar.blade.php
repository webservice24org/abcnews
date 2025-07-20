<header class="bg-red-600 h-[100px] relative" x-data="{ open: false }">
    <div class="mx-auto max-w-7xl px-4 h-full">
        <div class="grid grid-cols-12 h-full items-center">
            <!-- Logo -->
            <div class="col-span-6 md:col-span-3 flex items-center">
                <img src="{{ asset('storage/logos/front-logo.png') }}" alt="Logo" class="front-logo object-contain">
            </div>

            <!-- Desktop Navigation -->
            <div class="col-span-12 md:col-span-8 hidden md:flex justify-center items-start pt-4">
                <nav class="flex text-white text-sm font-semibold front-navbar">
                     <a href="/" class="px-4 pt-[10px] border-r border-white hover:underline">Home</a>
                    <a href="/news" class="px-4 pt-[10px] border-r border-white hover:underline">News</a>
                    <a href="/categories" class="px-4 pt-[10px] border-r border-white hover:underline">Categories</a>
                    <a href="/about" class="px-4 pt-[10px] border-r border-white hover:underline">About</a>
                    <a href="/contact" class="px-4 pt-[10px] hover:underline">Contact</a>
                </nav>
            </div>

            <!-- Hamburger Icon -->
            <div class="col-span-6 md:col-span-1 flex justify-end items-center">
                <button @click="open = !open" class="text-white focus:outline-none front-humberger">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="fixed top-0 right-0 w-[412px] max-w-full bg-yellow-400 text-black z-50 h-auto overflow-y-auto shadow-lg">
        <!-- Header Row -->
        <div class="p-4 flex justify-between items-center border-b border-black">
            <div>
                <a href="#" class="text-sm underline">Login</a> /
                <a href="#" class="text-sm underline">Sign Up</a>
            </div>
            <button @click="open = false" class="text-black text-xl font-bold">✕</button>
        </div>

        <!-- Search -->
        <div class="p-4 border-b border-black">
            <input 
                type="text" 
                placeholder="Search" 
                class="w-full p-2 rounded bg-white text-black focus:outline-none"
            >
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

        <!-- Navigation Links -->
        <nav class="flex flex-col space-y-3 p-4">
            @foreach(['Explainers', 'Politics', 'Culture', 'Advice', 'Science', 'Technology', 'Climate', 'Health', 'Money', 'Life'] as $item)
                <a href="#" class="text-lg font-medium border-b border-black pb-1">{{ $item }}</a>
            @endforeach
        </nav>

        <!-- Become a Member Button -->
        <div class="px-4 py-6">
            <a href="#" class="block w-full text-center bg-black text-white py-2 rounded font-bold hover:bg-gray-900 transition">
                Become a Member
            </a>
        </div>

        <!-- Social Links -->
        <div class="flex justify-center space-x-4 pb-6">
            <a href="#" class="text-xl hover:opacity-80" title="Facebook">🔵</a>
            <a href="#" class="text-xl hover:opacity-80" title="Twitter">🐦</a>
            <a href="#" class="text-xl hover:opacity-80" title="Instagram">📸</a>
        </div>

    </div>
</header>
