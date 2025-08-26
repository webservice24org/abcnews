<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $key;

    public function __construct()
    {
        $this->key = config('services.weatherapi.key');
    }

    // Current weather
    public function getCurrentWeather($city, $country = null)
    {
        try {
            $query = $country ? "{$city},{$country}" : $city;
            $response = Http::get("http://api.weatherapi.com/v1/current.json", [
                'key' => $this->key,
                'q' => $query,
                'aqi' => 'no'
            ]);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Weather API error', ['city' => $city, 'error' => $e->getMessage()]);
            return null;
        }
    }

    // Weather by coordinates
    public function getWeatherByCoords($lat, $lon)
    {
        try {
            $response = Http::get("http://api.weatherapi.com/v1/current.json", [
                'key' => $this->key,
                'q' => "{$lat},{$lon}",
                'aqi' => 'no'
            ]);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Weather API error', ['lat' => $lat, 'lon' => $lon, 'error' => $e->getMessage()]);
            return null;
        }
    }

    // Forecast (default: 5 days)
    public function getForecast($city, $days = 5)
    {
        try {
            $response = Http::get("http://api.weatherapi.com/v1/forecast.json", [
                'key' => $this->key,
                'q' => $city,
                'days' => $days,
                'aqi' => 'no',
                'alerts' => 'no'
            ]);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Weather Forecast API error', ['city' => $city, 'error' => $e->getMessage()]);
            return null;
        }
    }
    
    // app/Services/WeatherService.php

    public function searchCities($query)
    {
        try {
            $response = Http::get("http://api.weatherapi.com/v1/search.json", [
                'key' => $this->key,
                'q' => $query,
            ]);
            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            Log::error('WeatherAPI search error', ['query' => $query, 'error' => $e->getMessage()]);
            return [];
        }
    }

}
