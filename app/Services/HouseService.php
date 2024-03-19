<?php

namespace App\Services;

use App\Models\City;
use App\Models\House;

class HouseService
{
    public function save(array $data)
    {
        return House::query()->create($data);
    }
    public function saveHousingAttribute(House $house,array $data)
    {
        $house->createHousingAttribute($data);
    }
    public function cityCreate(\stdClass $address)
    {
        return City::query()->firstOrCreate(['name'=>$address->place_name],['name'=>$address->place_name]);
    }
}
