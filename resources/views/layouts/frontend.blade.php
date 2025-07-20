<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'News Portal')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS or Bootstrap -->
    @vite(['resources/css/app.css',])
    @livewireStyles
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
