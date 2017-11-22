<?php

namespace AppBundle\Model;

class Hotel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $city;

    /**
     * @var Availability[]
     */
    private $availability;

    /**
     * Hotel constructor.
     */
    public function __construct()
    {
        $this->availability = array();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return Availability[]
     */
    public function getAvailability():array
    {
        return $this->availability;
    }

    /**
     * @param Availability $availability
     */
    public function addAvailability(Availability $availability)
    {
        $this->availability[] = $availability;
    }

}