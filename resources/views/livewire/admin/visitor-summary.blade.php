<div class="p-6 bg-white rounded shadow">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold flex items-center">
            <x-flux::icon name="chart-bar" class="w-6 h-6 text-indigo-600 mr-2" />
            <span class="text-black">Website Visitor Summary</span>
        </h2>
        <div class="space-x-2">
            <button wire:click="$set('period','daily')" class="px-2 py-1 rounded font-bold {{ $period === 'daily' ? 'bg-red-600 text-white' : 'bg-gray-100 text-black' }}">Daily</button>
            <button wire:click="$set('period','weekly')" class="px-2 py-1 rounded font-bold {{ $period === 'weekly' ? 'bg-red-600 text-white' : 'bg-gray-100 text-black' }}">Weekly</button>
            <button wire:click="$set('period','monthly')" class="px-2 py-1 rounded font-bold {{ $period === 'monthly' ? 'bg-red-600 text-white' : 'bg-gray-100 text-black' }}">Monthly</button>
            <button wire:click="$set('period','yearly')" class="px-2 py-1 rounded font-bold {{ $period === 'yearly' ? 'bg-red-600 text-white' : 'bg-gray-100 text-black' }}">Yearly</button>
        </div>
    </div>
    <canvas id="visitorsChart" width="400" height="200"></canvas>


@push('scripts')
<script>
const ctx = document.getElementById('visitorsChart').getContext('2d');

let visitorsChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'Current Period',
                data: @json($current),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Previous Period',
                data: @json($previous),
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        animation: {
            duration: 800,
            easing: 'easeInOutQuart'
        },
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            title: {
                display: true,
                text: 'Visitor Trends (Current vs Previous)'
            }
        },
        scales: {
            x: { title: { display: true, text: 'Period' } },
            y: { beginAtZero: true, title: { display: true, text: 'Visitors' } }
        }
    }
});

// Livewire event listener
document.addEventListener('livewire:init', () => {
    Livewire.on('updateChart', (data) => {
        updateChartData(data.labels, data.current, data.previous);
    });
});

// Update chart function
function updateChartData(newLabels, newCurrentData, newPreviousData) {
    visitorsChart.data.labels = newLabels;
    visitorsChart.data.datasets[0].data = newCurrentData;
    visitorsChart.data.datasets[1].data = newPreviousData;

    visitorsChart.update({
        duration: 800,
        easing: 'easeInOutQuart'
    });
}
</script>
@endpush