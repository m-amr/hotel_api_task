<?php

namespace Tests\AppBundle\Service;


use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Tests\AppBundle\Mock\HotelAPIMock;

class HotelAPIMockTest extends TestCase
{
    public function testFetchData()
    {
        $hotelAPIMock = new HotelAPIMock();
        $hotels = $hotelAPIMock->fetchData();

        $this->assertCount(2, $hotels);

        $firstHotel = $hotels[0];
        $secondHotel = $hotels[1];

        $this->assertEquals('hotel-name-b', $firstHotel->getName());
        $this->assertEquals('city-name-b', $firstHotel->getCity());
        $this->assertEquals(40, $firstHotel->getPrice());
        $this->assertCount(1, $firstHotel->getAvailability());
        $this->assertEquals('10-1-2018', $firstHotel->getAvailability()[0]->getFrom());
        $this->assertEquals('15-1-2018', $firstHotel->getAvailability()[0]->getTo());


        $this->assertEquals('hotel-name-a', $secondHotel->getName());
        $this->assertEquals('city-name-a', $secondHotel->getCity());
        $this->assertEquals(30, $secondHotel->getPrice());
        $this->assertCount(1, $secondHotel->getAvailability());
        $this->assertEquals('1-1-2018', $secondHotel->getAvailability()[0]->getFrom());
        $this->assertEquals('5-1-2018', $secondHotel->getAvailability()[0]->getTo());

    }
}