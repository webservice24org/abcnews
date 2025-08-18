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

            
            @if (auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'Admin']))

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
                'admin.newsletter',
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
                        @if (auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                            <flux:navlist.item
                                icon="plus-circle"
                                :href="route('posts.create')"
                                :current="request()->routeIs('posts.create')"
                                wire:navigate
                                class="{{ request()->routeIs('posts.create') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Add New') }}
                            </flux:navlist.item>
                        @endif
                        <flux:navlist.item
                            icon="newspaper"
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
                        <flux:navlist.item
                            icon="newspaper"
                            :href="route('admin.newsletter')"
                            :current="request()->routeIs('admin.newsletter')"
                            wire:navigate
                            class="{{ request()->routeIs('admin.newsletter') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                            {{ __('News Letter') }}
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
            @php
                $photoNewsRoutes = [
                    'admin.photo-news.index',
                    'admin.photo-news.create',
                ];
                $photoNewsRoutesOpen = collect($photoNewsRoutes)->contains(fn($route) => request()->routeIs($route));
            @endphp

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ $photoNewsRoutesOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>{{ __('Photo News') }}</span>
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
                                :href="route('admin.photo-news.index')"
                                :current="request()->routeIs('admin.photo-news.index')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.photo-news.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('News List') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="plus-circle"
                                :href="route('admin.photo-news.create')"
                                :current="request()->routeIs('admin.photo-news.create')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.photo-news.create') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Add Photo News') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>

            @php
                $videoRoutes = [
                    'admin.video.list',
                    'admin.video.create',
                ];
                $isavideoRoutesOpen = collect($videoRoutes)->contains(fn($route) => request()->routeIs($route));
            @endphp

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ $isavideoRoutesOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>{{ __('Video News') }}</span>
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
                                :href="route('admin.video.list')"
                                :current="request()->routeIs('admin.video.list')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.video.list') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Video List') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="plus-circle"
                                :href="route('admin.video.create')"
                                :current="request()->routeIs('admin.video.create')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.video.create') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Add New Video') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>

             @php
                $appearanceOpenRoutes = [
                    'admin.menu-manager',
                    'admin.site-settings',
                    'admin.site-info',
                    'admin.site-connections',
                    'admin.social-connections',
                    'pulse',
                    'admin.custom-code',
                    'theme.color.picker',
                    'admin.analytics'
                ];
                $isAppearanceOpen = collect($appearanceOpenRoutes)->contains(fn($route) => request()->routeIs($route));
            @endphp

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ $isAppearanceOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>{{ __('Appearance') }}</span>
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
                                :href="route('admin.menu-manager')"
                                :current="request()->routeIs('admin.menu-manager')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.menu-manager') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Menu Settings') }}
                            </flux:navlist.item>

                           <flux:navlist.item
                                icon="photo"
                                :href="route('admin.site-settings')"
                                :current="request()->routeIs('admin.site-settings')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.site-settings') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Logo Settings') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="information-circle"
                                :href="route('admin.site-info')"
                                :current="request()->routeIs('admin.site-info')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.site-info') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Basic Informations') }}
                            </flux:navlist.item>
                            
                            <flux:navlist.item
                                icon="globe-alt"
                                :href="route('admin.site-connections')"
                                :current="request()->routeIs('admin.site-connections')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.site-connections') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Site Connections') }}
                            </flux:navlist.item>


                            <flux:navlist.item
                                icon="share"
                                :href="route('admin.social-connections')"
                                :current="request()->routeIs('admin.social-connections')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.social-connections') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Social Connections') }}
                            </flux:navlist.item>

                            <flux:navlist.item 
                                icon="sparkles" 
                                :href="route('pulse')" 
                                :current="request()->routeIs('pulse*')">
                                {{ __('Performance Monitor') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="tag" :href="route('admin.custom-code')" :current="request()->routeIs('admin.custom-code')">
                                {{ __('Custom CSS/JS Editor') }}
                            </flux:navlist.item>
                             <flux:navlist.item icon="home" :href="route('theme.color.picker')" :current="request()->routeIs('theme.color.picker')">
                                {{ __('Theme Color Picker') }}
                            </flux:navlist.item> 
                            <flux:navlist.item icon="home" :href="route('admin.analytics')" :current="request()->routeIs('admin.analytics')">
                                {{ __('Google Analytics') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>

             @php
                $advertisementpentRoutes = [
                    'admin.ads-list',
                    'admin.advertisements.create',
                ];
                $isadvertisementpentOpen = collect($advertisementpentRoutes)->contains(fn($route) => request()->routeIs($route));
            @endphp

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ $isadvertisementpentOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>{{ __('Advertisements') }}</span>
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
                                :href="route('admin.ads-list')"
                                :current="request()->routeIs('admin.ads-list')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.ads-list') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Advertisement List') }}
                            </flux:navlist.item>

                            <flux:navlist.item
                                icon="plus-circle"
                                :href="route('admin.advertisements.create')"
                                :current="request()->routeIs('admin.advertisements.create')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.advertisements.create') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Create Advertisement') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>


            @php
                $pageRoutes = [
                    'pages.index',
                ];
                $isPageRoutesOpen = collect($pageRoutes)->contains(fn($route) => request()->routeIs($route));
            @endphp

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ $isPageRoutesOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>{{ __('Page Manager') }}</span>
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
                                :href="route('pages.index')"
                                :current="request()->routeIs('pages.index')"
                                wire:navigate
                                class="{{ request()->routeIs('pages.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Page List') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>

             @php
                $contactRoutes = [
                    'contacts.index',
                    'admin.subscribers',
                ];
                $iscontactOpen = collect($contactRoutes)->contains(fn($route) => request()->routeIs($route));
            @endphp

            <flux:navlist variant="outline">
                <div x-data="{ open: {{ $iscontactOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-left font-medium text-yellow-100 hover:bg-gray-100 hover:text-black rounded">
                        <span>{{ __('Contact Manager') }}</span>
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
                                :href="route('contacts.index')"
                                :current="request()->routeIs('contacts.index')"
                                wire:navigate
                                class="{{ request()->routeIs('contacts.index') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Contact List') }}
                            </flux:navlist.item>
                            <flux:navlist.item
                                icon="list-bullet"
                                :href="route('admin.subscribers')"
                                :current="request()->routeIs('admin.subscribers')"
                                wire:navigate
                                class="{{ request()->routeIs('admin.subscribers') ? 'font-semibold bg-gray-200 rounded text-gray-900' : '' }}">
                                {{ __('Subscriber List') }}
                            </flux:navlist.item>

                        </flux:navlist.group>
                    </div>
                </div>
            </flux:navlist>

            
            
            <flux:navlist variant="outline">
                <flux:navlist.group class="grid">
                    <flux:navlist.item 
                        icon="sparkles" 
                        :href="route('admin.clear.cache')" 
                        :current="request()->routeIs('admin.clear.cache')" 
                        wire:navigate>
                        {{ __('Clear Cache') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            


            <!-- Desktop User Menu -->
            @auth
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                >
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
                            <span class="flex h-full w-full items-center justify-center rounded-full bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                                        <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>
                                @endif

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <span class="truncate text-xs">
                                        {{ auth()->user()->email }}
                                    </span>
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
            @endauth


        </flux:sidebar>

        <!-- Mobile User Menu -->
@auth
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            @php
                $profilePhoto = optional(auth()->user()->profile)->profile_photo;
            @endphp

            <flux:profile
                :name="auth()->user()->name"
                icon-trailing="chevron-down"
            >
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
                                <span class="truncate font-semibold">
                                    {{ auth()->user()->name }}
                                </span>
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
@endauth

{{ $slot }}

@fluxScripts

@stack('scripts')


        
    </body>
</html>
