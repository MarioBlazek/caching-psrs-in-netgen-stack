<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Weather\Cities;
use AppBundle\Weather\OpenWeatherMapClient;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class WeatherController
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * @var \AppBundle\Weather\OpenWeatherMapClient
     */
    private $openWeatherMapClient;

    public function __construct(Environment $twig, OpenWeatherMapClient $openWeatherMapClient)
    {
        $this->twig = $twig;
        $twig->getExtension(\Twig\Extension\CoreExtension::class)->setTimezone('Europe/Zagreb');
        $this->openWeatherMapClient = $openWeatherMapClient;
    }

    public function current(string $city): Response
    {
        $city = mb_strtolower(trim($city));

        $response = new Response();

        if (!$this->isValid($city)) {
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $weather = $this->openWeatherMapClient->getCurrentWeather($city);

        $renderedContent = $this->twig->render('@ezdesign/weather/current.html.twig', ['weather' => $weather]);

        $response->setContent($renderedContent);

        return $response;
    }

    private function isValid(string $city): bool
    {
        return in_array($city, Cities::getCities(), true);
    }
}
