<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Left: Recent Activity -->
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center mb-4">
            <x-flux::icon name="newspaper" class="w-10 h-10 text-indigo-600 mr-3" />
            <h2 class="text-xl font-semibold text-gray-800">Recent News Posts</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="py-2 px-4">Published Date</th>
                        <th class="py-2 px-4">Title</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPosts as $post)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="py-2 px-4">{{ $post->created_at->format('d M Y') }}</td>
                            <td class="py-2 px-4"><a href="{{ route('news.show', $post->slug) }}" target="_blank">{{ $post->news_title }}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-3 px-4 text-center text-gray-500">
                                No recent posts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Chart -->
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center mb-4">
            <x-flux::icon name="chart-bar" class="w-10 h-10 text-indigo-600 mr-3" />
            <h2 class="text-xl font-semibold text-gray-800">Posts Per Month</h2>
        </div>
        <canvas id="postsChart" height="200"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('livewire:navigated', () => {
    const ctx = document.getElementById('postsChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($postsPerMonth['labels']),
            datasets: [{
                label: 'Posts',
                data: @json($postsPerMonth['data']),
                backgroundColor: 'rgba(37, 99, 235, 0.2)',
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });
});
</script>
@endpush
