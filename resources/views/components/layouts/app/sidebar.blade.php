<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
            <flux:navlist variant="outline">
    
                <div x-data="{ open: {{ request()->routeIs('roles.index') || request()->routeIs('permissions.index') || request()->routeIs('users.index') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>User Management</span>
                        <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <svg x-show="open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition>
                        <flux:navlist.group class="pl-4 mt-1">

                            <flux:navlist.item
                                icon="users"
                                :href="route('roles.index')"
                                :current="request()->routeIs('roles.index')"
                                wire:navigate
                                class="{{ request()->routeIs('roles.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Roles') }}
                            </flux:navlist.item>
                            
                            

                            <flux:navlist.item
                                icon="key"
                                :href="route('permissions.index')"
                                :current="request()->routeIs('permissions.index')"
                                wire:navigate
                                class="{{ request()->routeIs('permissions.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Permissions') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="user"
                                :href="route('users.index')"
                                :current="request()->routeIs('users.index')"
                                wire:navigate
                                class="{{ request()->routeIs('users.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Users') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>

            </flux:navlist>
            @endif

           @php
    $newsRoutes = [
        'posts.create',
        'news.index',
        'news.drafts',
        'news.scheduled',
        'posts.trashed',
    ];
    $isNewsOpen = collect($newsRoutes)->contains(fn($route) => request()->routeIs($route));
@endphp

<flux:navlist variant="outline">
    <div x-data="{ open: {{ $isNewsOpen ? 'true' : 'false' }} }">
        <button @click="open = !open"
            class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">

            <span>{{ __('News Management') }}</span>
            <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
            <svg x-show="open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
        </button>

        <div x-show="open" x-transition>
            <flux:navlist.group class="pl-4 mt-1">

                <flux:navlist.item
                    icon="plus-circle"
                    :href="route('posts.create')"
                    :current="request()->routeIs('posts.create')"
                    wire:navigate
                    class="{{ request()->routeIs('posts.create') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                    {{ __('Add New') }}
                </flux:navlist.item>

                <flux:navlist.item
                    icon="plus-circle"
                    :href="route('news.index')"
                    :current="request()->routeIs('news.index')"
                    wire:navigate
                    class="{{ request()->routeIs('news.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                    {{ __('All News') }}
                </flux:navlist.item>

                <flux:navlist.item
                    icon="document-text"
                    :href="route('news.drafts')"
                    :current="request()->routeIs('news.drafts')"
                    wire:navigate
                    class="{{ request()->routeIs('news.drafts') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                    {{ __('Drafts') }}
                </flux:navlist.item>

                <flux:navlist.item
                    icon="clock"
                    :href="route('news.scheduled')"
                    :current="request()->routeIs('news.scheduled')"
                    wire:navigate
                    class="{{ request()->routeIs('news.scheduled') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                    {{ __('Scheduled') }}
                </flux:navlist.item>

                <flux:navlist.item
                    icon="trash"
                    :href="route('posts.trashed')"
                    :current="request()->routeIs('posts.trashed')"
                    wire:navigate
                    class="{{ request()->routeIs('posts.trashed') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                    {{ __('Trashed') }}
                </flux:navlist.item>

            </flux:navlist.group>
        </div>
    </div>
</flux:navlist>


            
            @php
                $newsSettingsRoutes = [
                    'categories.index',
                    'sub-categories.index',
                    'divisions.index',
                    'districts.index',
                    'upazilas.index',
                    'tags.index',
                ];
                $isNewsSettingsOpen = collect($newsSettingsRoutes)->contains(fn($route) => request()->routeIs($route));
            @endphp
            

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ $isNewsSettingsOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>{{ __('News Settings') }}</span>
                        <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <svg x-show="open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition>
                        <flux:navlist.group class="pl-4 mt-1">
                            <flux:navlist.item
                                icon="list-bullet"
                                :href="route('categories.index')"
                                :current="request()->routeIs('categories.index')"
                                wire:navigate
                                class="{{ request()->routeIs('categories.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Categories') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="tag"
                                :href="route('sub-categories.index')"
                                :current="request()->routeIs('sub-categories.index')"
                                wire:navigate
                                class="{{ request()->routeIs('sub-categories.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Sub-Categories') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="globe-alt"
                                :href="route('divisions.index')"
                                :current="request()->routeIs('divisions.index')"
                                wire:navigate
                                class="{{ request()->routeIs('divisions.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Divisions') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="map"
                                :href="route('districts.index')"
                                :current="request()->routeIs('districts.index')"
                                wire:navigate
                                class="{{ request()->routeIs('districts.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Districts') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="map-pin"
                                :href="route('upazilas.index')"
                                :current="request()->routeIs('upazilas.index')"
                                wire:navigate
                                class="{{ request()->routeIs('upazilas.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Upazilas') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="tag"
                                :href="route('tags.index')"
                                :current="request()->routeIs('tags.index')"
                                wire:navigate
                                class="{{ request()->routeIs('tags.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Tags') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>







            <flux:spacer />

            


            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                >
                    <!-- Add profile photo preview if exists -->
                    @php
                        $photo = auth()->user()->profile?->profile_photo;
                    @endphp
                    @if ($photo)
                        <img
                            src="{{ asset('storage/' . $photo) }}"
                            alt="Profile Photo"
                            class="w-8 h-8 rounded-full object-cover border"
                        />
                    @else
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full">
                            <span
                                class="flex h-full w-full items-center justify-center rounded-full bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                            >
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                    @endif
                </flux:profile>

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                @if ($photo)
                                    <img
                                        src="{{ asset('storage/' . $photo) }}"
                                        alt="Profile Photo"
                                        class="w-8 h-8 rounded-full object-cover border"
                                    />
                                @else
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>
                                @endif

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>

        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :name="auth()->user()->name"
                    icon-trailing="chevron-down"
                >
                    @php
                        $profilePhoto = optional(auth()->user()->profile)->profile_photo;
                    @endphp

                    @if ($profilePhoto)
                        <img
                            src="{{ asset('storage/' . $profilePhoto) }}"
                            alt="Profile Picture"
                            class="w-8 h-8 rounded-full object-cover"
                        />
                    @else
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                        >
                            {{ auth()->user()->initials() }}
                        </span>
                    @endif
                </flux:profile>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    @if ($profilePhoto)
                                        <img
                                            src="{{ asset('storage/' . $profilePhoto) }}"
                                            alt="Profile Picture"
                                            class="h-8 w-8 rounded-full object-cover"
                                        />
                                    @else
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    @endif
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>
        {{ $slot }}
        
        @fluxScripts
        @livewireScripts
        @stack('scripts')
        
    </body>
</html>
