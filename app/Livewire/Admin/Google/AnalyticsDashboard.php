<?php

namespace App\Livewire\Admin\Google;

use Livewire\Component;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use App\Models\AnalyticsConfig;

class AnalyticsDashboard extends Component
{
    public $visitors = 0;
    public $pageViews = 0;
    public $sessions = 0;
    public $dailyStats = [];
    public $topPages = [];
    public $topCountries = [];
    public $deviceBreakdown = [];
    public $activeUsersNow = 0;

    public $darkMode = false; // Dark mode toggle

    protected $listeners = ['refreshRealtime'];

    public function mount()
    {
        $this->loadAnalytics();
    }

    public function toggleDarkMode()
    {
        $this->darkMode = !$this->darkMode;
    }

    private function loadAnalyticsConfig()
    {
        $config = AnalyticsConfig::first();
        if ($config) {
            // Set GA property ID dynamically
            config(['analytics.property_id' => $config->property_id]);

            // Save service account JSON dynamically
            $path = storage_path('app/analytics/service-account-credentials.json');
            file_put_contents($path, $config->service_account_json);
        }
    }

    public function loadAnalytics()
    {
        // Always reload GA config dynamically before fetching data
        $this->loadAnalyticsConfig();

        $period = Period::days(30);

        // Visitors + PageViews
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews($period);
        $this->visitors = $analyticsData->sum('visitors');
        $this->pageViews = $analyticsData->sum('pageViews');

        // Sessions (GA4)
        $sessionsData = Analytics::get(
            period: $period,
            metrics: ['sessions'],
            dimensions: ['date']
        );
        $this->sessions = collect($sessionsData)->sum('sessions');

        // Daily stats for trend chart
        $byDate = collect($analyticsData)->keyBy(fn ($r) => Carbon::parse($r['date'])->format('Y-m-d'));
        $bySessions = collect($sessionsData)->keyBy('date');

        $this->dailyStats = collect(range(0, 29))
            ->map(fn ($i) => Carbon::today()->subDays(29 - $i)->format('Y-m-d'))
            ->map(function ($ymd) use ($byDate, $bySessions) {
                return [
                    'date' => Carbon::parse($ymd)->format('M d'),
                    'visitors' => (int) ($byDate[$ymd]['visitors'] ?? 0),
                    'pageViews' => (int) ($byDate[$ymd]['pageViews'] ?? 0),
                    'sessions' => (int) ($bySessions[$ymd]['sessions'] ?? 0),
                ];
            })->values();

        // Top Pages
        $this->topPages = Analytics::fetchMostVisitedPages($period, 5)
            ->map(fn ($r) => [
                'url' => $r['url'],
                'pageTitle' => $r['pageTitle'],
                'pageViews' => $r['pageViews'],
            ])->toArray();

        // Top Countries
        $countries = Analytics::get(
            period: $period,
            metrics: ['totalUsers'],
            dimensions: ['country']
        );
        $this->topCountries = collect($countries)
            ->sortByDesc('totalUsers')
            ->take(5)
            ->map(fn ($r) => [
                'country' => $r['country'] ?? 'Unknown',
                'totalUsers' => (int) ($r['totalUsers'] ?? 0),
            ])->toArray();

        // Device breakdown
        $devices = Analytics::get(
            period: $period,
            metrics: ['totalUsers'],
            dimensions: ['deviceCategory']
        );
        $this->deviceBreakdown = collect($devices)
            ->map(fn ($r) => [
                'deviceCategory' => $r['deviceCategory'] ?? 'Unknown',
                'totalUsers' => (int) ($r['totalUsers'] ?? 0),
            ])->toArray();

        // Realtime active users
        $this->refreshRealtime();
    }

    // Livewire listener to refresh active users every 10s
    public function refreshRealtime()
    {
        // Reload GA config dynamically in case it's changed
        $this->loadAnalyticsConfig();

        $realtime = Analytics::getRealtime(
            period: Period::create(Carbon::today(), Carbon::today()),
            metrics: ['activeUsers']
        );
        $this->activeUsersNow = $realtime['activeUsers'] ?? 0;
    }

    public function render()
    {
        return view('livewire.admin.google.analytics-dashboard');
    }
}
