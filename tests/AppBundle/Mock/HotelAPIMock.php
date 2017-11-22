<?php

namespace Tests\AppBundle\Mock;

use AppBundle\Model\Availability;
use AppBundle\Model\Hotel;
use AppBundle\Service\AbstractHotelAPI;

class HotelAPIMock extends AbstractHotelAPI
{
    /**
     * @return Hotel[]
     */
    public function fetchData():array
    {
        $hotelA = new Hotel();
        $hotelA->setName('hotel-name-a');
        $hotelA->setPrice(30);
        $hotelA->setCity('city-name-a');

        $availabilityA = new Availability();
        $availabilityA->setFrom('1-1-2018');
        $availabilityA->setTo('5-1-2018');

        $hotelA->addAvailability($availabilityA);

        $hotelB = new Hotel();
        $hotelB->setName('hotel-name-b');
        $hotelB->setPrice(40);
        $hotelB->setCity('city-name-b');

        $availabilityB = new Availability();
        $availabilityB->setFrom('10-1-2018');
        $availabilityB->setTo('15-1-2018');

        $hotelB->addAvailability($availabilityB);

        return array($hotelB, $hotelA);
    }

    protected function getAPIURL():string
    {
        return '';
    }

    protected function convertJSONToObject(array $response):array
    {
        return [];
    }

}