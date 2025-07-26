<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    @livewireStyles
</head>
<body class="bg-white text-gray-800">

    
        @include('partials.front.frontend-navbar')
    

    <!-- Content -->
     <main class="max-w-7xl mx-auto px-4 py-4">
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @livewireScripts

    
</body>
</html>
