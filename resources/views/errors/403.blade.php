<x-layouts.app title="403 Forbidden">
    <div class="flex items-center justify-center h-screen text-center">
        <div>
            <h1 class="text-4xl font-bold text-red-600 mb-4">403</h1>
            <p class="text-lg text-gray-700 mb-6">You are not authorized to access this page.</p>
            <a href="{{ route('dashboard') }}" class="text-indigo-600 underline">Return to Dashboard</a>
        </div>
    </div>
</x-layouts.app>
