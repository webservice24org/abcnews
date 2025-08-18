<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Total Posts -->
    <div class="flex items-center p-5 bg-white rounded shadow hover:shadow-lg transition">
        <x-flux::icon name="newspaper" class="w-10 h-10 text-blue-600" />
        <div class="ml-4">
            <p class="text-gray-500">Total Posts</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $totalPosts }}</h2>
            <a href="{{route('news.index')}}" class="bg-red-500 text-white p-1 rounded">view all</a>
        </div>
    </div>

    <!-- Drafted Posts -->
    <div class="flex items-center p-5 bg-white rounded shadow hover:shadow-lg transition">
        <x-flux::icon name="pencil" class="w-10 h-10 text-yellow-600" />
        <div class="ml-4">
            <p class="text-gray-500">Drafted Posts</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $totalDrafted }}</h2>
            <a href="{{route('news.drafts')}}" class="bg-red-500 text-white p-1 rounded">view all</a>
        </div>
    </div>

    <!-- Scheduled Posts -->
    <div class="flex items-center p-5 bg-white rounded shadow hover:shadow-lg transition">
        <x-flux::icon name="calendar" class="w-10 h-10 text-green-600" />
        <div class="ml-4">
            <p class="text-gray-500">Scheduled Posts</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $scheduledPosts }}</h2>
            <a href="{{route('news.scheduled')}}" class="bg-red-500 text-white p-1 rounded">view all</a>
        </div>
    </div>

    <!-- Active Users -->
    <div class="flex items-center p-5 bg-white rounded shadow hover:shadow-lg transition">
        <x-flux::icon name="user-group" class="w-10 h-10 text-indigo-600" />
        <div class="ml-4">
            <p class="text-gray-500">Active Users</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $activeUsers }}</h2>
            <a href="{{route('users.index')}}" class="bg-red-500 text-white p-1 rounded">view all</a>
        </div>
    </div>

    <!-- Inactive Users -->
    <div class="flex items-center p-5 bg-white rounded shadow hover:shadow-lg transition">
        <x-flux::icon name="user-minus" class="w-10 h-10 text-red-600" />
        <div class="ml-4">
            <p class="text-gray-500">Inactive Users</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $inactiveUsers }}</h2>
        </div>
    </div>
    <div class="flex items-center p-5 bg-white rounded shadow hover:shadow-lg transition">
        <x-flux::icon name="user-group" class="w-10 h-10 text-red-600" />
        <div class="ml-4">
            <p class="text-gray-500">Subscribers</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $subscribers }}</h2>
            <a href="{{route('admin.subscribers')}}" class="bg-red-500 text-white p-1 rounded">view all</a>
        </div>
    </div>
</div>
