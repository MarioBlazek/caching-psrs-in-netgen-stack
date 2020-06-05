<?php

namespace AppBundle\Weather;

final class CacheKeyRegistry
{
    public const OPEN_WEATHER_MAP_TAG = 'openweathermap';

    public function getCurrentWeatherKey(string $city): string
    {
        return 'openweather_map_city_' . md5($city);
    }
}
