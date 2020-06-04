<?php

namespace AppBundle\Weather;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class Psr6DecoratedOpenWeatherMapClient extends OpenWeatherMapClient
{
    /**
     * @var \AppBundle\Weather\OpenWeatherMapClient
     */
    private $client;

    /**
     * @var \Symfony\Component\Cache\Adapter\AdapterInterface
     *
     */
    private $adapter;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * @var int
     */
    private $ttl;

    public function __construct(OpenWeatherMapClient $client, AdapterInterface $adapter, ConfigResolverInterface $configResolver)
    {
        $this->client = $client;
        $this->adapter = $adapter;
        $this->configResolver = $configResolver;
        $this->ttl = $this->configResolver->getParameter('weather.ttl', 'app');
    }

    public function getCurrentWeather(string $city): array
    {
        $key = $this->getKey($city);

        $item = $this->adapter->getItem($key);

        if ($item->isHit()) {
            return $item->get();
        }

        $weather = $this->client->getCurrentWeather($city);

        if (empty($weather)) {
            return [];
        }

        $item->set($weather);
        $item->expiresAfter(10);

        $this->adapter->save($item);

        return $weather;
    }

    private function getKey(string $city): string
    {
        return 'openweather_map_city_' . md5($city);
    }
}
