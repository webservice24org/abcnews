<div class="bg-white shadow rounded-lg p-5 hover:shadow-lg transition duration-300">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold flex items-center">
            <x-flux::icon name="chart-bar" class="w-6 h-6 text-indigo-600 mr-2" />
            Website Visitor Summary
        </h2>
        <select wire:model="period" class="border rounded p-1">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>

    <canvas id="visitorChart" height="100"></canvas>
</div>

@push('scripts')
<script>
document.addEventListener('livewire:load', function () {
    let chart;

    function renderChart(labels, current, previous) {
        const ctx = document.getElementById('visitorChart').getContext('2d');
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Current Period',
                        data: current,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'Previous Period',
                        data: previous,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: false,
                        borderDash: [5, 5],
                        tension: 0.3
                    }
                ]
            },
            options: { responsive: true }
        });
    }

    Livewire.on('refreshChart', data => {
        renderChart(data.labels, data.current, data.previous);
    });

    // Render initial chart
    renderChart(@json($labels), @json($current), @json($previous));
});
</script>
@endpush
