<?php

declare(strict_types=1);

namespace AppBundle\Weather;

use eZ\Publish\Core\MVC\ConfigResolverInterface;

class OpenWeatherMapUrlBuilder
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $appid;

    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->baseUrl = $configResolver->getParameter('weather.base_url', 'app');
        $this->appid = $configResolver->getParameter('weather.appid', 'app');
    }

    public function getUrl(string $city): string
    {
        $queryData = [
            'q' => $city,
            'appid' => $this->appid,
            'units' => 'metric',
            'lang' => 'en',
        ];

        return $this->baseUrl . '?' . http_build_query($queryData);
    }
}
