<?php

namespace AppBundle\Weather;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Psr\Cache\CacheItemPoolInterface;

class Psr6DecoratedOpenWeatherMapClient extends OpenWeatherMapClient
{
    /**
     * @var \AppBundle\Weather\OpenWeatherMapClient
     */
    private $client;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     *
     */
    private $pool;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var \AppBundle\Weather\CacheKeyRegistry
     */
    private $keyRegistry;

    public function __construct(
        OpenWeatherMapClient $client,
        CacheItemPoolInterface $pool,
        ConfigResolverInterface $configResolver,
        CacheKeyRegistry $keyRegistry
    )
    {
        $this->client = $client;
        $this->pool = $pool;
        $this->configResolver = $configResolver;
        $this->ttl = $this->configResolver->getParameter('weather.ttl', 'app');
        $this->keyRegistry = $keyRegistry;
    }

    public function getCurrentWeather(string $city): array
    {
        $key = $this->keyRegistry->getCurrentWeatherKey($city);

        $item = $this->pool->getItem($key);

        if ($item->isHit()) {
            return $item->get();
        }

        $weather = $this->client->getCurrentWeather($city);

        if (empty($weather)) {
            return [];
        }

        $item->set($weather);
        $item->expiresAfter($this->ttl);
//        $item->tag(CacheKeyRegistry::OPEN_WEATHER_MAP_TAG);

        $this->pool->save($item);

        return $weather;
    }
}
