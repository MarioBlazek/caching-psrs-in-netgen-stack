<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testCurrent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/weather/current');
    }

}
