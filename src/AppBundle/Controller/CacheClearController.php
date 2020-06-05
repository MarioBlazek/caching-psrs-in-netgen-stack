<?php

namespace AppBundle\Controller;

use AppBundle\Weather\CacheKeyRegistry;
use AppBundle\Weather\Cities;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class CacheClearController
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface
     */
    private $pool;

    /**
     * @var \AppBundle\Weather\CacheKeyRegistry
     */
    private $keyRegistry;

    public function __construct(CacheItemPoolInterface $pool, CacheKeyRegistry $keyRegistry)
    {
        $this->pool = $pool;
        $this->keyRegistry = $keyRegistry;
    }

    public function clearCacheByCity(string $city): Response
    {
        $city = strtolower(trim($city));

        $response = new Response();

        if (!$this->isValid($city)) {
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $key = $this->keyRegistry->getCurrentWeatherKey($city);

        try {
            $this->pool->deleteItem($city);
        } catch (InvalidArgumentException $e) {

            return $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    public function clearCacheByWeatherTag(): Response
    {
        $response = new Response();

        try {
            $this->pool->invalidateTags([CacheKeyRegistry::OPEN_WEATHER_MAP_TAG]);
        } catch (InvalidArgumentException $exception) {
            return $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    private function isValid(string $city): bool
    {
        return in_array($city, Cities::getCities());
    }
}
