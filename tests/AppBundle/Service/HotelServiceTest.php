<?php

namespace Tests\AppBundle\Service;

use AppBundle\Model\Hotel;
use AppBundle\Model\HotelQueryOptions;
use AppBundle\Service\HotelService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Tests\AppBundle\Mock\HotelAPIMock;

class HotelServiceTest extends TestCase
{

    public function testSearchWithNoQueryOptions()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $hotels = $hotelService->search();

        $this->assertCount(2, $hotels);

        $firstHotel = $hotels[0];
        $secondHotel = $hotels[1];

        $this->assertHotelBHelper($firstHotel);
        $this->assertHotelAHelper($secondHotel);

    }

    public function testSearchWithNameFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setName('hotel-name-b');
        $hotels = $hotelService->search($queryOption);

        $this->assertCount(1, $hotels);

        $firstHotel = $hotels[0];
        $this->assertHotelBHelper($firstHotel);
    }

    public function testSearchWithNotFoundNameFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setName('hotel-name-c');
        $hotels = $hotelService->search($queryOption);

        $this->assertCount(0, $hotels);

    }

    public function testSearchWithCityFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setCity('city-name-b');
        $hotels = $hotelService->search($queryOption);

        $this->assertCount(1, $hotels);

        $firstHotel = $hotels[0];

        $this->assertHotelBHelper($firstHotel);

    }

    public function testSearchWithWrongCityFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setCity('city-name-c');
        $hotels = $hotelService->search($queryOption);

        $this->assertCount(0, $hotels);
    }

    public function testSearchWithAvailableDateFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setAvailableFrom('2-1-2018');
        $queryOption->setAvailableTo('3-1-2018');

        $hotels = $hotelService->search($queryOption);
        $this->assertCount(1, $hotels);
        $this->assertHotelAHelper($hotels[0]);

        $queryOption->setAvailableFrom('12-1-2018');
        $queryOption->setAvailableTo('13-1-2018');

        $hotels = $hotelService->search($queryOption);
        $this->assertCount(1, $hotels);
        $this->assertHotelBHelper($hotels[0]);
    }

    public function testSearchWithWrongAvailableDateFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setAvailableFrom('2-2-2018');
        $queryOption->setAvailableTo('3-2-2018');

        $hotels = $hotelService->search($queryOption);
        $this->assertCount(0, $hotels);
    }

    public function testSearchWithPriceFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setPriceFrom(20);
        $queryOption->setPriceTo(35);

        $hotels = $hotelService->search($queryOption);
        $this->assertCount(1, $hotels);
        $this->assertHotelAHelper($hotels[0]);

    }

    public function testSearchWithWrongPriceFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setPriceFrom(60);
        $queryOption->setPriceTo(80);

        $hotels = $hotelService->search($queryOption);
        $this->assertCount(0, $hotels);
    }

    public function testSearchWithSortByNameFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setSortBy(HotelQueryOptions::SORT_BY_NAME);
        $hotels = $hotelService->search($queryOption);
        $this->assertCount(2, $hotels);

        $this->assertHotelAHelper($hotels[0]);
        $this->assertHotelBHelper($hotels[1]);

    }

    public function testSearchWithSortByPriceFilter()
    {
        $hotelService = $this->createHotelAPIServiceHelper();
        $queryOption = new HotelQueryOptions();
        $queryOption->setSortBy(HotelQueryOptions::SORT_BY_PRICE);
        $hotels = $hotelService->search($queryOption);
        $this->assertCount(2, $hotels);

        $this->assertHotelAHelper($hotels[0]);
        $this->assertHotelBHelper($hotels[1]);

    }

    public function assertHotelAHelper(Hotel $hotel)
    {
        $this->assertEquals('hotel-name-a', $hotel->getName());
        $this->assertEquals('city-name-a', $hotel->getCity());
        $this->assertEquals(30, $hotel->getPrice());
        $this->assertCount(1, $hotel->getAvailability());
        $this->assertEquals('1-1-2018', $hotel->getAvailability()[0]->getFrom());
        $this->assertEquals('5-1-2018', $hotel->getAvailability()[0]->getTo());
    }

    public function assertHotelBHelper(Hotel $hotel)
    {

        $this->assertEquals('hotel-name-b', $hotel->getName());
        $this->assertEquals('city-name-b', $hotel->getCity());
        $this->assertEquals(40, $hotel->getPrice());
        $this->assertCount(1, $hotel->getAvailability());
        $this->assertEquals('10-1-2018', $hotel->getAvailability()[0]->getFrom());
        $this->assertEquals('15-1-2018', $hotel->getAvailability()[0]->getTo());

    }


    public function createHotelAPIServiceHelper():HotelService
    {
        $hotelAPIMock = new HotelAPIMock();
        $hotelService = new HotelService($hotelAPIMock);
        return $hotelService;

    }
}