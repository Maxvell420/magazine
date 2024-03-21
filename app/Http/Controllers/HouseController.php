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
        $title = "Обьявление {$house->city->name}, $house->title";
        $service = new DashboardService();
        $watchlist = $service->getFavouriteHouses(Auth::user());
        $house->load('city');
        $house->load('photos');
        $house->processExternalData();
        $data = $house->getInfo();
        $data = $house->eraseNulls($data);
        $house->user->getUsabilityTime($house->user->created_at);
        $user = Auth::user();
        return view('house.show',compact(['house','watchlist','user','data','title']));
    }
    public function edit(House $house)
    {
        $title = "Редактирование обьявления $house->city->name, $house->title";
        $info = $house->getInfo();
        $house->load('photos');
        return view('house.edit',compact(['house','info','title']));
    }
    public function create()
    {
        $title = 'Создание обьявления';
        return view('house.create',compact('title'));
    }
    public function confirmation(Request $request)
    {
        $title = 'Подтверждение данных';
        $service = new HouseService();
        $validated = $service->validateHouseData($request);
        $streetData = $request->validate([
            'city'=>'required',
            'street'=>'required',
            'building'=>'required',
        ]);
        $addresses = $this->addressRetrieve($streetData);
        if ($addresses){
            return view('house.address',compact(['addresses','validated','title']));
        } else {
            Session::flash('message','wrong location provided');
            $request->validate(['message'=>'required']);
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
        $house = $service->save($request,$city->id);
        $service->createHousingAttribute($house,$request);
        $coordinate = $house->createCoordinate($address);
        $coordinate->downloadMap();
        $pictures = $request->file('pictures');
        if (isset($pictures)){
            $service->savePhotos($house,$pictures);
        }
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

        $service = new HouseService();
        $pictures = $request->file('pictures');
        if (isset($pictures)){
            $service->savePhotos($house,$pictures);
        }
        $service->updateHouseInfo($house,$request);
        $service->updateHousingAttribute($house,$request);
        return redirect()->back()->with('success', 'Обьявление успешно обновлено');
    }
    public function unzip(House $house)
    {
        $house->update(['archived'=>0]);
        return \redirect()->back()->with('message','Обьявление убрано из архива');
    }
    public function photoDelete(House $house,Photo $photo)
    {
        $photo->photoFileDelete();
        $photo->delete();
        return \redirect()->back();
    }
}
