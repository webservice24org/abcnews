<x-layouts.app :title="__('Dashboard')">

<div
    x-data="{sidebarOpened: false}"
    @sidebar-opened.window="sidebarOpened = $event.detail.status"
    class="flex min-h-screen overflow-hidden"
>
    <aside class="w-64 bg-gray-100 border-r transition"
           :class="sidebarOpened ? 'block' : 'hidden sm:block'">
        <livewire:comments-admin-sidebar/>
    </aside>

    <div
        class="flex-1 p-6 overflow-auto text-black transition "
        :class="sidebarOpened ? 'bg-[rgba(9,9,11,.5)]' : 'bg-white opacity-100'"
    >
        @if(isset($linearNavigation))
            <div>
                {{$linearNavigation}}
            </div>
        @endif

        <header class="my-6">{{$header}}</header>

        <main>
            {{ $slot }}
        </main>
    </div>
</div>
@livewire('notifications')
@filamentScripts
</x-layouts.app>