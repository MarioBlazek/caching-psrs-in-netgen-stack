<?php

namespace AppBundle\Controller;

use AppBundle\Weather\OpenWeatherMapClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class WeatherController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var OpenWeatherMapClient
     */
    private $openWeatherMapClient;

    public function __construct(Environment $twig, OpenWeatherMapClient $openWeatherMapClient)
    {
        $this->twig = $twig;
        $this->openWeatherMapClient = $openWeatherMapClient;
    }

    public function current(string $city): Response
    {
        $weather = $this->openWeatherMapClient->getCurrentWeather($city);

        $renderedContent = $this->twig->render('@ezdesign/weather/current.html.twig', ['weather' => $weather]);

        $response = new Response();
        $response->setContent($renderedContent);

        return $response;
    }
}
