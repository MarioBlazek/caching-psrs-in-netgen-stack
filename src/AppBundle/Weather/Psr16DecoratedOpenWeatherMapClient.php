<?php

declare(strict_types=1);

namespace AppBundle\Weather;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Simple\Psr6Cache;
use Psr\SimpleCache\CacheInterface;

class Psr16DecoratedOpenWeatherMapClient implements OpenWeatherMapClientInterface
{
    /**
     * @var \AppBundle\Weather\OpenWeatherMapClientInterface
     */
    private $client;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    private $cache;

    /**
     * @var \AppBundle\Weather\CacheKeyRegistry
     */
    private $keyRegistry;

    public function __construct(
        OpenWeatherMapClient $client,
        AdapterInterface $adapter,
        ConfigResolverInterface $configResolver,
        CacheKeyRegistry $keyRegistry
    ) {
        $this->client = $client;
        $this->configResolver = $configResolver;
        $this->ttl = $this->configResolver->getParameter('weather.ttl', 'app');
        $this->cache = new Psr6Cache($adapter);
        $this->keyRegistry = $keyRegistry;
    }

    public function getCurrentWeather(string $city): array
    {
        $key = $this->keyRegistry->getCurrentWeatherKey($city);

        if (!$this->cache->has($key)) {
            $weather = $this->client->getCurrentWeather($city);
        } else {
            $weather = $this->cache->get($key);
        }

        if (empty($weather)) {
            return [];
        }

        $this->cache->set($key, $weather, $this->ttl);

        return $weather;
    }
}
