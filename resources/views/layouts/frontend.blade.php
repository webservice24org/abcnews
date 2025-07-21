<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body class="bg-white text-gray-800">

    
        @include('partials.frontend-navbar')
    

    <!-- Content -->
     <main class="max-w-7xl mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    @livewireScripts
    
</body>
</html>
