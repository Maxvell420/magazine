<?php

namespace App\Services;

use App\Models\City;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class HouseService
{
    public function save(Request $request,int $city_id)
    {
        $data = $this->validateHouseInfo($request);
        $data['user_id']=Auth::user()->id;
        $data['city_id']=$city_id;
        return House::query()->create($data);
    }
    public function validateHouseData(Request $request)
    {
        $housingAttribute = $this->validateHousingAttribute($request);
        $houseInfo = $this->validateHouseInfo($request);
        return array_merge($housingAttribute,$houseInfo);
    }
    private function validateHousingAttribute(Request $request): array
    {
        return $request->validate([
            'metro'=>[],
            'rooms'=>[],
            'fridge'=>[],
            'dishwasher'=>[],
            'clothWasher'=>[],
            'balcony'=>[],
            'bathroom'=>[],
            'pledge'=>[],
            'author'=>[],
            'infrastructure'=>['max:255'],
            'description'=>['max:255'],
        ]);
    }
    public function savePhotos(House $house,array $pictures)
    {
        foreach ($pictures as $picture){
            if ($house->photos()->get()->count()>=4){
                if (empty(\session('message'))){
                    session()->flash('message','Максимум 4 фотографии в обьявлении');
                }
                continue;
            }
            $this->storePhoto($house,$picture);
        }
    }
    private function storePhoto(House $house, UploadedFile $picture)
    {
        $photo = $house->photos()->firstOrCreate(['name'=>$picture->getClientOriginalName(),'path'=>"houses/$house->id"],['name'=>$picture->getClientOriginalName(),'path'=>"houses/$house->id"]);
        $photo->downloadPhoto($picture);
    }
    private function validateHouseInfo(Request $request)
    {
        return $request->validate([
            'title'=>['required'],
            'price'=>['required','gt:0'],
        ]);
    }
    public function updateHouseInfo(House $house,Request $request)
    {
        $data = $this->validateHouseInfo($request);
        $house->update($data);
    }
    public function createHousingAttribute(House $house, Request $request)
    {
        $data = $this->validateHousingAttribute($request);
        $house->createHousingAttribute($data);
    }
    public function updateHousingAttribute(House $house,Request $request)
    {
        $data = $this->validateHousingAttribute($request);
        $data = $house->addNulls($data);
        $house->updateHousingAttribute($data);
    }
    public function cityCreate(\stdClass $address)
    {
        $cityName = $address->place_name;
        $patterns = ['#^\s*г\s*#u','#^\s*[Г|г]ород\s*#u'];
        foreach ($patterns as $pattern){
            $cityName=preg_replace($pattern,'',$cityName);
        }
        return City::query()->firstOrCreate(['name'=>$cityName],['name'=>$cityName]);
    }
}
