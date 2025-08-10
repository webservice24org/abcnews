<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <livewire:admin.dashboard-summary />
        <livewire:admin.recent-activity />

        <livewire:admin.visitor-summary />

    </div>
</x-layouts.app>

