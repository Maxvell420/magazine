<?php

namespace App\Classes;

use App\Models\Coordinate;

class GeoEncoder
{
    private string $street;
    private string $city;
    private string $building;
    public function __construct(private string $appKey, array $data)
    {
        $this->city = $data['city'];
        $this->building =  $data['building'];
        $this->street = $data['street'];
    }
    public function fetchCoordinates()
    {
        $url = "https://api.geotree.ru/address.php?key=".$this->appKey.'&term='.urlencode("$this->city $this->street $this->building");
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type: application/json']);
        $data = json_decode(curl_exec($curl));
        curl_close($curl);
        return $data;
    }
}
