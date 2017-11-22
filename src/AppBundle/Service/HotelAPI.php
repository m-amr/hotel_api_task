<?php

namespace AppBundle\Service;

use AppBundle\Model\Availability;
use AppBundle\Model\Hotel;

class HotelAPI extends AbstractHotelAPI
{
    /**
     * @return string
     */
    protected function getAPIURL():string
    {
        return "http://api.myjson.com/bins/tl0bp";
    }

    /**
     * @param $response
     *
     * @return Hotel[]
     */
    protected function convertJSONToObject(array $response):array
    {
        $hotelArray = array();

        if (isset($response['hotels']) && is_array($response['hotels'])) {
            foreach ($response['hotels'] as $hotel) {
                $hotelModel = new Hotel();
                $hotelModel->setName($hotel['name']);
                $hotelModel->setCity($hotel['city']);
                $hotelModel->setPrice($hotel['price']);


                if (isset($hotel['availability']) && is_array($hotel['availability'])) {
                    foreach ($hotel['availability'] as $availability) {
                        $availabilityModel = new Availability();
                        $availabilityModel->setFrom($availability['from']);
                        $availabilityModel->setTo($availability['to']);

                        $hotelModel->addAvailability($availabilityModel);
                    }
                }

                $hotelArray[] = $hotelModel;
            }
        }

        return $hotelArray;
    }

}