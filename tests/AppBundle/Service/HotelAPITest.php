<?php

namespace Tests\AppBundle\Service;


use AppBundle\Model\Availability;
use AppBundle\Model\Hotel;
use AppBundle\Service\HotelAPI;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class HotelAPITest extends TestCase
{
    public function testFetchData()
    {
        $hotelAPI = new HotelAPI();
        $hotels = $hotelAPI->fetchData();

        $this->assertTrue(is_array($hotels));
        $this->assertGreaterThan(0, count($hotels));

        foreach($hotels as $hotel){
            $this->assertInstanceOf(Hotel::class, $hotel);

            $this->assertNotNull($hotel->getName());
            $this->assertNotNull($hotel->getCity());
            $this->assertNotNull($hotel->getPrice());

            foreach($hotel->getAvailability() as $available){
                $this->assertInstanceOf(Availability::class, $available);

                $this->assertNotNull($available->getFrom());
                $this->assertNotNull($available->getTo());

            }
        }
    }

    public function testProtectedGetAPIURL()
    {
        //Use reflection to test private methods
        $hotelAPIObject = new HotelAPI();
        $hotelAPIObjectClass = new \ReflectionClass(HotelAPI::class);

        $method = $hotelAPIObjectClass->getMethod('getAPIURL');
        $method->setAccessible(true);

        $actual=$method->invoke($hotelAPIObject);
        $expected = 'http://api.myjson.com/bins/tl0bp';

        $this->assertEquals($expected, $actual);
    }


    public function testProtectedConvertJsonToObject()
    {
        //Use reflection to test private methods
        $hotelAPIObject = new HotelAPI();
        $hotelAPIObjectClass = new \ReflectionClass(HotelAPI::class);

        $method = $hotelAPIObjectClass->getMethod('convertJSONToObject');
        $method->setAccessible(true);

        $actual = $method->invokeArgs(
            $hotelAPIObject,
            [
                [
                    'hotels' => [
                        [
                            'name' => 'hotel-name',
                            'price' => 10,
                            'city' => 'city-name',
                            'availability' => [
                                [
                                    'from' => '1-1-2010',
                                    'to' => '2-1-2010'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );

        $availability = new Availability();
        $availability->setFrom('1-1-2010');
        $availability->setTo('2-1-2010');

        $hotel = new Hotel();
        $hotel->setName('hotel-name');
        $hotel->setCity('city-name');
        $hotel->setPrice(10);
        $hotel->addAvailability($availability);

        $expected = [$hotel];
        $this->assertEquals($expected, $actual);
    }
}