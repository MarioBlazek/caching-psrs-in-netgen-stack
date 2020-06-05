<?php

namespace AppBundle\Weather;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OpenWeatherMapClient
{
    /**
     * @var \AppBundle\Weather\OpenWeatherMapConfigResolver
     */
    private $configResolver;

    /**
     * @var \Http\Client\HttpClient
     */
    private $client;

    /**
     * @var \Http\Message\MessageFactory
     */
    private $messageFactory;

    public function __construct(
        OpenWeatherMapConfigResolver $configResolver,
        HttpClient $client,
        MessageFactory $messageFactory
    )
    {
        $this->configResolver = $configResolver;
        $this->client = $client;
        $this->messageFactory = $messageFactory;
    }

    public function getCurrentWeather(string $city): array
    {
        $url = $this->configResolver->getUrl($city);

        $request = $this->messageFactory
            ->createRequest(
                Request::METHOD_GET,
                $url
            );

        try {
            $response = $this->client->sendRequest($request);
        } catch (\Exception $exception) {
            return [];
        }

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return [];
        }

        return json_decode((string)$response->getBody(), true);
    }
}
