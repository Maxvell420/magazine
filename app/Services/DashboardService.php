<?php

namespace App\Services;
use App\Models\City;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
class DashboardService
{
    public function getFilteredHouses(Request $request)
    {
        $houses=House::getHousesFromFilter($request,House::with('city'));
        $houses=$houses->where('archived','!=',true)
            ->whereHas('user',function ($query){
                $query->where('frozen',0);
            })->simplePaginate(6);
        $houses->map(function ($house){
//            Получаю адрес и ссылку на превью в виде аттрибута модели
            $house->processExternalData();
        });
        return $houses;
    }
    public function getCities()
    {
        return City::all();
    }
    public function getFavouriteHouses(?User $user): array
    {
        if (!$user){
            return [];
        }
        return $user->getWatchlist();
    }
}
