<?php
/**
 * Created by PhpStorm.
 * User: amr
 * Date: 11/20/17
 * Time: 7:54 AM
 */

namespace AppBundle\Model;


class HotelQueryOptions
{
    const SORT_BY_NAME = 'name';
    const SORT_BY_PRICE = 'price';

    const DATE_TIME_FORMAT = 'd-m-Y';

    static $SORT_OPTIONS = [
        self::SORT_BY_NAME,
        self::SORT_BY_PRICE
    ];

    private $name;

    private $city;

    private $priceFrom;

    private $priceTo;

    private $availableFrom;

    private $availableTo;

    private $sortBy;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * @param mixed $priceFrom
     */
    public function setPriceFrom($priceFrom)
    {
        $this->priceFrom = $priceFrom;
    }

    /**
     * @return mixed
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }

    /**
     * @param mixed $priceTo
     */
    public function setPriceTo($priceTo)
    {
        $this->priceTo = $priceTo;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * @param mixed $availableFrom
     */
    public function setAvailableFrom($availableFrom)
    {
        $this->availableFrom = $availableFrom;
    }

    /**
     * @return mixed
     */
    public function getAvailableTo()
    {
        return $this->availableTo;
    }

    /**
     * @param mixed $availableTo
     */
    public function setAvailableTo(string $availableTo)
    {
        $this->availableTo = $availableTo;
    }

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param mixed $sortBy
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }

}