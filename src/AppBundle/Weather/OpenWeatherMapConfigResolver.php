<?php

namespace AppBundle\Weather;

use eZ\Publish\Core\MVC\ConfigResolverInterface;

class OpenWeatherMapConfigResolver
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

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
        $this->configResolver = $configResolver;
        $this->baseUrl = $this->configResolver->getParameter('weather.base_url', 'app');
        $this->appid = $this->configResolver->getParameter('weather.appid', 'app');
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
