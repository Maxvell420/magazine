<?php

namespace App\Models;

use App\Services\CoordinateService;
use App\Traits\FileOperationsTrait;
use App\Traits\UsabilityTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use stdClass;

class House extends Model
{
    use HasFactory,FileOperationsTrait,UsabilityTime;
    protected $fillable=['user_id','city_id','title','price','archived'];
    protected array $info = ['rooms','description','fridge',
        'dishwasher','clothWasher','balcony','bathroom','pledge','infrastructure','author'];
    public static function getHousesFromFilter(Request $request,Builder $houses)
    {
        $city = $request->input('city');
        $rooms = $request->input('rooms');
        $price = $request->input('price');
        $dishwasher = $request->input('dishwasher');
        $clothwasher = $request->input('clothWasher');
        $bathroom = $request->input('bathroom');
        $fridge = $request->input('fridge');
        $author = $request->input('author');
        if (isset($city) and $city != 0){
            $houses=$houses->where('city_id','=',$city);
        }
        if (isset($rooms)){
            $houses=$houses->where('rooms','>=',$rooms);
        }
        if (isset($price)){
            $houses=$houses->where('price','>=',$price);
        }
        if (isset($dishwasher)){
            $houses=$houses->whereHas('housing_attribute',function ($query) use ($dishwasher){
                $query->where('dishwasher','=',$dishwasher);
            });
        }
        if (isset($fridge)){
            $houses=$houses->whereHas('housing_attribute',function ($query) use ($fridge){
                $query->where('fridge','=',$fridge);
            });
        }
        if (isset($clothwasher)){
            $houses=$houses->whereHas('housing_attribute',function ($query) use ($clothwasher){
                $query->where('clothWasher','=',$clothwasher);
            });
        }
        if (isset($bathroom) and $bathroom != 0){
            $houses=$houses->whereHas('housing_attribute',function ($query) use ($bathroom){
                $query->where('bathroom','=',$bathroom);
            });
        }
        if (isset($author)){
            $houses=$houses->whereHas('housing_attribute',function ($query) use ($author){
                $query->where('author','=',$author);
            });
        }
        return $houses;
    }
    public function getInfo()
    {
        $data = [];
        $attributes = $this->housing_attribute;
        $info = $this->info;
        foreach ($info as $value){
                $data[$value]=$attributes->$value;
        }
        return $data;
    }
    public function eraseNulls(array $info)
    {
        foreach ($info as $item => $value){
            if ($value == null){
                unset($info[$item]);
            }
        }
        return $info;
    }
    public function createCoordinate(stdClass $address)
    {
        $coordinateService = new CoordinateService($address);
        $lon = $coordinateService->getLon();
        $lat = $coordinateService->getLat();
        $building = $coordinateService->getBuilding();
        $street = $coordinateService->getStreet();
        return $this->coordinate()->create(['city_id'=>$this->city_id,'lon'=>$lon,'lat'=>$lat,'street'=>$street,'building'=>$building,'name'=>"$street-$building"]);
    }
    public function complaintCounter()
    {
        $user = $this->user;
        $complaint = $user->complaints;
        if ($complaint->count()>=3){
            if ($user->role_id<2){
                $user->freeze();
            }
        }
    }
    public function photosFileDelete()
    {
        $photos = $this->photos()->get();
        foreach ($photos as $photo){
            $photo->fileDelete();
        }
    }
    public function deletePhotosFiles()
    {
        $photos = $this->photos()->get();
        $this->filesDelete($photos);
    }
    public function coordinateFileDelete()
    {
        $coordinate = $this->coordinate()->first();
        $this->fileDelete($coordinate->path,$coordinate->name);
    }
    public function getPreviewPath()
    {
        if ($this->photos){
            $photo = $this->photos->first();
            return $this->setAttribute('preview',$photo->path.'/'.$photo->name);
        }
    }
    public function processExternalData()
    {
        $this->getPreviewPath();
        $this->getAddress();
//        класс который меняет дату прям здесь
        $this->getUsabilityTime($this->created_at);
    }
    public function getAddress()
    {
        return $this->setAttribute('address',$this->coordinate->getAddress());
    }
    public function coordinate()
    {
        return $this->hasOne(Coordinate::class);
    }
    public function housing_attribute()
    {
        return $this->hasOne(Housing_attribute::class);
    }
    public function saveHousingAttribute(array $data)
    {
        $this->housing_attribute()->update($data);
    }
    public function createHousingAttribute(array $data)
    {
        $this->housing_attribute()->create($data);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
