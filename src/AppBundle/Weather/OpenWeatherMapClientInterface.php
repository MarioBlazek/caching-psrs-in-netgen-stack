<?php

declare(strict_types=1);

namespace AppBundle\Weather;

interface OpenWeatherMapClientInterface
{
    /**
     * Returns the current weather information
     * for given city.
     *
     * @param string $city
     *
     * @return array
     */
    public function getCurrentWeather(string $city): array;
}
