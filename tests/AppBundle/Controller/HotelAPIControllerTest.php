<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HotelAPIControllerTest extends WebTestCase
{
    public function testIndexHeaders()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/hotels');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type',
            'application/json'
        ));

        $this->assertTrue($client->getResponse()->headers->contains(
            'Pragma',
            'no-cache'
        ));

        $cacheControlArray = explode(',', $client->getResponse()->headers->get('Cache-Control'));
        $cacheControlArray = array_map(
            function ($item) {
                return trim($item);
            },
            $cacheControlArray
        );


        $this->assertContains('no-store', $cacheControlArray);
        $this->assertContains('no-cache', $cacheControlArray);
        $this->assertContains('must-revalidate', $cacheControlArray);
        $this->assertContains('max-age=0', $cacheControlArray);
    }
}