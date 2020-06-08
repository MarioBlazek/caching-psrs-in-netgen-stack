<?php

declare(strict_types=1);

namespace AppBundle\Weather;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class OpenWeatherMapClient implements OpenWeatherMapClientInterface
{
    /**
     * @var \AppBundle\Weather\OpenWeatherMapUrlBuilder
     */
    private $urlBuilder;

    /**
     * @var \Http\Client\HttpClient
     */
    private $client;

    /**
     * @var \Http\Message\MessageFactory
     */
    private $messageFactory;

    public function __construct(
        OpenWeatherMapUrlBuilder $urlBuilder,
        HttpClient $client,
        MessageFactory $messageFactory
    ) {
        $this->client = $client;
        $this->messageFactory = $messageFactory;
        $this->urlBuilder = $urlBuilder;
    }

    public function getCurrentWeather(string $city): array
    {
        $url = $this->urlBuilder->getUrl($city);

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

        return json_decode((string) $response->getBody(), true);
    }
}
