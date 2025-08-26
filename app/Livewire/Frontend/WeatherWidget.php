<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\WeatherService;

class WeatherWidget extends Component
{
    public $weather;
    public $forecast;
    public $city = 'Dhaka';
    public $country = 'BD';
    public $search = '';
    public $suggestions = [];

    protected $listeners = ['setLocation' => 'loadWeatherByCoords', 'setCityFromLocalStorage' => 'setCityFromLocalStorage'];

    public function updatedSearch(WeatherService $service)
    {
        if (strlen($this->search) > 2) {
            $this->suggestions = $service->searchCities($this->search);
        } else {
            $this->suggestions = [];
        }
    }

    public function selectCity($name)
    {
        $this->city = $name;
        $this->search = $name;
        $this->suggestions = [];
        $this->dispatch('save-city', ['city' => $this->city]);
        $this->loadData(app(WeatherService::class), $this->city);
    }

    public function mount(WeatherService $service)
    {
        $this->loadData($service, $this->city);
    }

    public function loadData(WeatherService $service, $city)
    {
        $this->weather = $service->getCurrentWeather($city);
        $this->forecast = $service->getForecast($city, 5);
    }

    public function searchCity(WeatherService $service)
    {
        if (!empty($this->search)) {
            $this->city = $this->search;
            $this->loadData($service, $this->city);
            $this->dispatch('save-city', ['city' => $this->city]);
        }
    }

    public function loadWeatherByCoords($lat, $lon, WeatherService $service)
    {
        $this->weather = $service->getWeatherByCoords($lat, $lon);
        if ($this->weather) {
            $this->city = $this->weather['location']['name'];
            $this->forecast = $service->getForecast($this->city, 5);
        }
    }

    public function setCityFromLocalStorage($city, WeatherService $service)
    {
        $this->city = $city;
        $this->loadData($service, $this->city);
    }

    public function render()
    {
        return view('livewire.frontend.weather-widget');
    }
}
