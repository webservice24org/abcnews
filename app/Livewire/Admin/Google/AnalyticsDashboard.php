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

    public $darkMode = false; 

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
            
            config(['analytics.property_id' => $config->property_id]);

            
            $path = storage_path('app/analytics/service-account-credentials.json');
            file_put_contents($path, $config->service_account_json);
        }
    }

    public function loadAnalytics()
    {
        
        $this->loadAnalyticsConfig();

        $period = Period::days(30);

        
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews($period);
        $this->visitors = $analyticsData->sum('visitors');
        $this->pageViews = $analyticsData->sum('pageViews');

       
        $sessionsData = Analytics::get(
            period: $period,
            metrics: ['sessions'],
            dimensions: ['date']
        );
        $this->sessions = collect($sessionsData)->sum('sessions');

       
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

        
        $this->topPages = Analytics::fetchMostVisitedPages($period, 5)
            ->map(fn ($r) => [
                'url' => $r['url'],
                'pageTitle' => $r['pageTitle'],
                'pageViews' => $r['pageViews'],
            ])->toArray();

        
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

        
        $this->refreshRealtime();
    }

   
    public function refreshRealtime()
    {
        
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
