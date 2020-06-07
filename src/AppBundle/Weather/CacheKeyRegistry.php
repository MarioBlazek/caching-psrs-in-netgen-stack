<?php

declare(strict_types=1);

namespace AppBundle\Weather;

final class CacheKeyRegistry
{
    public const OPEN_WEATHER_MAP_TAG = 'openweathermap';

    public function getCurrentWeatherKey(string $city): string
    {
        return 'openweather_map_city_' . $city;
    }
}
