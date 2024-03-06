<?php

namespace App\Services;

use App\Models\House;

class CoordinateService
{
    private string $lon;
    private string $lat;
    private string $building;
    private string $street;
    public function __construct(\stdClass $address)
    {
        $this->fetchData($address);
    }

    /**
     * @return string
     */
    public function getLat(): string
    {
        return $this->lat;
    }

    /**
     * @return string
     */
    public function getLon(): string
    {
        return $this->lon;
    }

    /**
     * @return string
     */
    public function getBuilding(): string
    {
        return $this->building;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }
    private function fetchData(\stdClass $address)
    {
        $addressValues = array_reverse(explode(', ',$address->value));
        $this->building = $addressValues[0];
        $this->street = $addressValues[1];
        $this->lat=$address->geo_center->lat;
        $this->lon=$address->geo_center->lon;
    }
}
