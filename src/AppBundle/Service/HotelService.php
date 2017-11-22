<?php

namespace AppBundle\Service;

use AppBundle\Model\Availability;
use AppBundle\Model\Hotel;
use AppBundle\Model\HotelQueryOptions;

class HotelService
{
    private $hotelAPI;

    private $hotels;

    /**
     * HotelService constructor.
     *
     * @param AbstractHotelAPI $hotelAPI
     */
    public function __construct(AbstractHotelAPI $hotelAPI)
    {
        $this->hotelAPI = $hotelAPI;
    }

    /**
     * @param HotelQueryOptions|null $queryOptions
     *
     * @return Hotel[]
     */
    public function search(HotelQueryOptions $queryOptions = null):array
    {
        $this->hotels = array();
        $this->hotels = $this->hotelAPI->fetchData();

        if ($queryOptions !== null) {
            $this->filterHotels($queryOptions);
            $this->sortHotels($queryOptions);
        }

        return $this->hotels;

    }

    private function filterHotels(HotelQueryOptions $queryOptions)
    {
        $this->hotels = array_values(
            array_filter(
                $this->hotels,
                function (Hotel $hotel) use ($queryOptions) {

                    if ($queryOptions->getName() && !$this->compareName($hotel, $queryOptions->getName())) {
                        return false;
                    }

                    if ($queryOptions->getCity() && !$this->compareCity($hotel, $queryOptions->getCity())) {
                        return false;
                    }

                    if ($queryOptions->getPriceFrom() && $queryOptions->getPriceTo()) {
                        if (!$this->comparePriceRange(
                            $hotel,
                            $queryOptions->getPriceFrom(),
                            $queryOptions->getPriceTo()
                        )
                        ) {
                            return false;
                        }
                    }

                    if ($queryOptions->getAvailableFrom() && $queryOptions->getAvailableTo()) {
                        if (!$this->compareAvailableRange(
                            $hotel,
                            $queryOptions->getAvailableFrom(),
                            $queryOptions->getAvailableTo()
                        )
                        ) {
                            return false;
                        }
                    }

                    return true;
                }
            )
        );
    }

    private function sortHotels(HotelQueryOptions $queryOptions)
    {
        if ($queryOptions->getSortBy() === HotelQueryOptions::SORT_BY_NAME) {
            $this->sortByName();
        }

        if ($queryOptions->getSortBy() === HotelQueryOptions::SORT_BY_PRICE) {
            $this->sortByPrice();
        }
    }

    private function compareName(Hotel $hotel, $name)
    {
        return $hotel->getName() === $name;
    }

    private function compareCity(Hotel $hotel, $city)
    {
        return $hotel->getCity() === $city;
    }

    private function comparePriceRange(Hotel $hotel, $from, $to)
    {
        if ($from !== null && $to !== null) {
            return ($hotel->getPrice() >= $from && $hotel->getPrice() <= $to);
        } elseif ($from !== null) {
            return $hotel->getPrice() >= $from;
        } elseif ($to !== null) {
            return $hotel->getPrice() <= $to;
        }

        return true;
    }

    private function compareAvailableRange(Hotel $hotel, $from, $to)
    {
        $targetDateFrom = \DateTime::createFromFormat(HotelQueryOptions::DATE_TIME_FORMAT, $from);
        $targetDateTo = \DateTime::createFromFormat(HotelQueryOptions::DATE_TIME_FORMAT, $to);

        /** @var Availability $availability */
        foreach ($hotel->getAvailability() as $availability) {
            $availableFrom = \DateTime::createFromFormat(HotelQueryOptions::DATE_TIME_FORMAT, $availability->getFrom());
            $availableTo = \DateTime::createFromFormat(HotelQueryOptions::DATE_TIME_FORMAT, $availability->getTo());

            if ($targetDateFrom >= $availableFrom && $targetDateFrom <= $availableTo &&
                $targetDateTo <= $availableTo && $targetDateTo >= $availableFrom
            ) {
                return true;
            }

        }

        return false;

    }


    private function sortByName()
    {
        usort(
            $this->hotels,
            function (Hotel $a, Hotel $b) {
                if ($a == $b) {
                    return 0;
                }

                return ($a->getName() < $b->getName()) ? -1 : 1;
            }
        );
    }

    private function sortByPrice()
    {
        usort(
            $this->hotels,
            function (Hotel $a, Hotel $b) {
                if ($a == $b) {
                    return 0;
                }

                return ($a->getPrice() < $b->getPrice()) ? -1 : 1;
            }
        );
    }
}