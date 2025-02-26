<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()  
    {   
        $city = request('city', 'Kuressaare');

        return Inertia::render('Dashboard', [
            'weather' => Cache::remember('weather'.$city, now()->addHour(), fn () => $this->getWeatherData($city))
        ]);
    }
    
    private function getWeatherData($city)
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'units' => 'metric',
            'appid' => config('services.open_weather_map.key')
        ]);

        return $response->json();
    }
}