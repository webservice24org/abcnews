<div class="{{ $darkMode ? 'dark bg-gray-900 text-gray-100' : 'bg-gray-50 text-gray-900' }} p-6 min-h-screen transition-colors duration-300">

    <!-- Header + Dark Mode Toggle -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📊 Google Analytics Dashboard</h2>
        <button wire:click="toggleDarkMode"
            class="px-4 py-2 rounded-md shadow hover:shadow-lg transition
                   bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            {{ $darkMode ? '🌙 Dark Mode' : '☀️ Light Mode' }}
        </button>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 text-center">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Visitors (30 Days)</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $visitors }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 text-center">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Page Views</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $pageViews }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 text-center">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Sessions</h3>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $sessions }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 text-center">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Active Users Now</h3>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400" id="activeUsers">{{ $activeUsersNow }}</p>
        </div>
    </div>

    <!-- Trend Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">📈 30-Day Trend</h3>
        <canvas id="analyticsChart" class="w-full" height="120"></canvas>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">🌎 Top Countries</h3>
            <canvas id="countriesChart" class="w-full" height="150"></canvas>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">📱 Device Breakdown</h3>
            <canvas id="devicesChart" class="w-full" height="150"></canvas>
        </div>
    </div>

    <!-- Top Pages Table with Border -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">🔥 Top 5 Pages</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border text-left divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="p-3 text-sm font-medium border-b border-gray-300 dark:border-gray-600">Page Title</th>
                        <th class="p-3 text-sm font-medium border-b border-gray-300 dark:border-gray-600">URL</th>
                        <th class="p-3 text-sm font-medium border-b border-gray-300 dark:border-gray-600 text-right">Views</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($topPages as $page)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="p-3 text-sm text-gray-700 dark:text-gray-200">{{ $page['pageTitle'] ?: 'N/A' }}</td>
                        <td class="p-3 text-sm text-blue-600 dark:text-blue-400 truncate max-w-xs">
                            <a href="{{ $page['url'] }}" target="_blank">{{ $page['url'] }}</a>
                        </td>
                        <td class="p-3 text-sm text-gray-700 dark:text-gray-200 text-right">{{ $page['pageViews'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let darkMode = @json($darkMode);

    function getColors() {
        return {
            trend: {
                visitors: darkMode ? '#60A5FA' : '#3B82F6',
                visitorsBg: darkMode ? 'rgba(96,165,250,0.1)' : 'rgba(59,130,246,0.1)',
                pageViews: darkMode ? '#34D399' : '#10B981',
                pageViewsBg: darkMode ? 'rgba(52,211,153,0.1)' : 'rgba(16,185,129,0.1)',
                sessions: darkMode ? '#A78BFA' : '#8B5CF6',
                sessionsBg: darkMode ? 'rgba(167,139,250,0.1)' : 'rgba(139,92,246,0.1)',
            },
            countries: {
                bg: darkMode ? '#60A5FA' : '#3B82F6',
                border: darkMode ? '#2563EB' : '#1E40AF'
            },
            devices: {
                bg: ['#60A5FA','#34D399','#FBBF24']
            }
        };
    }

    function renderCharts() {
        const colors = getColors();

        // Trend Chart
        const trendCtx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json($dailyStats->pluck('date')),
                datasets: [
                    { label: 'Visitors', data: @json($dailyStats->pluck('visitors')), borderColor: colors.trend.visitors, backgroundColor: colors.trend.visitorsBg, fill: true, tension: 0.3, pointRadius: 3 },
                    { label: 'Page Views', data: @json($dailyStats->pluck('pageViews')), borderColor: colors.trend.pageViews, backgroundColor: colors.trend.pageViewsBg, fill: true, tension: 0.3, pointRadius: 3 },
                    { label: 'Sessions', data: @json($dailyStats->pluck('sessions')), borderColor: colors.trend.sessions, backgroundColor: colors.trend.sessionsBg, fill: true, tension: 0.3, pointRadius: 3 }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { font: { size: 12 }, color: darkMode ? '#F9FAFB' : '#111827' } }, tooltip: { backgroundColor: darkMode ? '#1F2937' : '#111827', titleColor: '#fff', bodyColor: '#fff', padding: 10, cornerRadius: 6 } },
                scales: { x: { grid: { display: false }, ticks: { color: darkMode ? '#D1D5DB' : '#374151' } }, y: { beginAtZero: true, ticks: { color: darkMode ? '#D1D5DB' : '#374151' }, grid: { color: darkMode ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)' } } }
            }
        });

        // Top Countries
        const countriesCtx = document.getElementById('countriesChart').getContext('2d');
        new Chart(countriesCtx, {
            type: 'bar',
            data: { labels: @json(collect($topCountries)->pluck('country')), datasets: [{ label: 'Users', data: @json(collect($topCountries)->pluck('totalUsers')), backgroundColor: colors.countries.bg, borderColor: colors.countries.border, borderWidth: 1, borderRadius: 4 }] },
            options: { responsive: true, plugins: { legend: { display: false }, tooltip: { backgroundColor: darkMode ? '#1F2937' : '#111827', titleColor: '#fff', bodyColor: '#fff', padding: 10, cornerRadius: 6 } }, scales: { x: { grid: { display: false }, ticks: { color: darkMode ? '#D1D5DB' : '#374151' } }, y: { beginAtZero: true, ticks: { color: darkMode ? '#D1D5DB' : '#374151' }, grid: { color: darkMode ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)' } } } }
        });

        // Device Breakdown
        const devicesCtx = document.getElementById('devicesChart').getContext('2d');
        const deviceLabels = @json(collect($deviceBreakdown)->pluck('deviceCategory'));
        const deviceData = @json(collect($deviceBreakdown)->pluck('totalUsers'));
        new Chart(devicesCtx, {
            type: 'doughnut',
            data: { labels: deviceLabels.length ? deviceLabels : ['Desktop','Mobile','Tablet'], datasets: [{ data: deviceData.length ? deviceData : [0,0,0], backgroundColor: colors.devices.bg, hoverOffset: 10, borderWidth: 2 }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 12 }, color: darkMode ? '#F9FAFB' : '#111827' } }, tooltip: { backgroundColor: darkMode ? '#1F2937' : '#111827', titleColor: '#fff', bodyColor: '#fff', padding: 10, cornerRadius: 6 } } }
        });
    }

    renderCharts();

    // Auto-refresh active users every 10s
    setInterval(() => { @this.call('refreshRealtime'); }, 10000);

    // Re-render charts when dark mode toggled
    Livewire.on('refreshCharts', () => {
        darkMode = @this.get('darkMode');
        renderCharts();
    });
</script>
@endpush
