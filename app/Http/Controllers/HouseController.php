<?php

namespace App\Http\Controllers;

use App\Classes\GeoEncoder;
use App\Models\City;
use App\Models\House;
use App\Models\Photo;
use App\Services\DashboardService;
use App\Services\HouseService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class HouseController extends Controller
{
    public function show(House $house)
    {
        $user = Auth::user();
        $service = new DashboardService();
        $watchlist = $service->getFavouriteHouses($user);
        $house->load('city');
        $house->load('photos');
        return view('house.show',compact(['house','watchlist']));
    }
    public function create()
    {
        return view('house.create');
    }
    public function confirmation(Request $request)
    {
        $validated = $request->validate([
            'title'=>['required','max:15'],
            'price'=>['required','gt:0'],
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
        $streetData = $request->validate([
            'city'=>'required',
            'street'=>'required',
            'building'=>'required',
        ]);
        $addresses = $this->addressRetrieve($streetData);
        if ($addresses){
            return view('house.address',compact(['addresses','validated']));
        } else {
            Session::flash('message','wrong location provided');
            $request->validate(['title'=>'required']);
        }
    }
    public function archive(House $house)
    {
        $house->update(['archived'=>'1']);
        return \redirect()->back()->with('message','announcement was archived');
    }
    private function addressRetrieve(array $data)
    {
        $appKey = env('GEO_KEY');
        $geoEncoder = new GeoEncoder($appKey,$data);
        return $geoEncoder->fetchCoordinates();
    }
    public function save(Request $request)
    {
        $service = new HouseService();
        $address = json_decode($request->input('address'));
        $city = $service->cityCreate($address);
        $houseData= $request->validate([
            'title'=>['required','max:15'],
            'price'=>['required','gt:0'],
        ]);
        $houseParams = $request->validate([
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
        $houseData['user_id']=Auth::user()->id;
        $houseData['city_id']=$city->id;
        $house = $service->save($houseData);
        $service->saveHousingAttribute($house,$houseParams);
        $coordinate = $house->createCoordinate($address);
        $coordinate->downloadMap();
        return redirect()->route('house.show',$house);
    }
    public function houseDelete(House $house)
    {
        $user = Auth::user();
        if ($user->id == $house->user_id or $user->role_id>1){
            $house->deletePhotosFiles();
            $house->coordinateFileDelete();
            $house->delete();
        }
        return redirect()->route('user.dashboard')->with('message','announcement was deleted');
    }

    public function update(Request $request,House $house)
    {
        $pictures = $request->file('pictures');
        if (isset($pictures)){
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
        $validated = $request->validate([
            'price'=>['required','gt:0'],
            'rooms'=>['required','gt:0'],
            'description'=>['max:255'],
        ]);
        $house->update($validated);
        return redirect()->back()->with('success', 'Обьявление успешно обновлено');
    }
    private function storePhoto(House $house, UploadedFile $picture)
    {
        $photo = $house->photos()->firstOrCreate(['name'=>$picture->getClientOriginalName(),'path'=>"houses/$house->id"],['name'=>$picture->getClientOriginalName(),'path'=>"houses/$house->id"]);
        $photo->downloadPhoto($picture);
    }
    public function unzip(House $house)
    {
        $house->update(['archived'=>0]);
        return \redirect()->back()->with('message','Обьявление убрано из архива');
    }
    public function photoDelete(Photo $photo)
    {
        $photo->photoFileDelete();
        $photo->delete();
        return \redirect()->back();
    }
}
