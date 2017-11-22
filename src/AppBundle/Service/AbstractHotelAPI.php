<?php

namespace AppBundle\Service;

use AppBundle\Model\Hotel;

abstract class AbstractHotelAPI
{
    /**
     * @return Hotel[]
     */
    public function fetchData():array
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get($this->getAPIURL());
        $response = json_decode($response->getBody(), true);
        $response = $this->convertJSONToObject($response);

        return $response;
    }

    /**
     * @return string
     */
    protected abstract function getAPIURL():string;

    /**
     * @param $response
     *
     * @return Hotel[]
     */
    protected abstract function convertJSONToObject(array $response):array ;

}