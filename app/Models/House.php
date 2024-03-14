<?php

namespace App\Models;

use App\Services\CoordinateService;
use App\Traits\FileOperationsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use stdClass;

class House extends Model
{
    use HasFactory,FileOperationsTrait;
    protected $fillable=['user_id','city_id','title','price','archived'];
    public static function getHousesFromFilter(Request $request,Builder $houses)
    {
        $city = $request->input('city');
        $rooms = $request->input('rooms');
        $price = $request->input('price');
        if (isset($city)){
            $houses=$houses->where('city_id','=',$city);
        }
        if (isset($rooms)){
            $houses=$houses->where('rooms','>=',$rooms);
        }
        if (isset($price)){
            $houses=$houses->where('price','>=',$price);
        }
        return $houses;
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
        if (!$this->photos){
            return $this->setAttribute('preview',$this->photos->first()->path);
        } else {
            return $this->setAttribute('preview',$this->coordinate->getMap());
        }
    }
    public function processExternalData()
    {
        $this->getPreviewPath();
        $this->getAddress();
//        класс который меняет дату прям здесь
        $this->getUsabilityTime($this->created_at);
    }
    public function getUsabilityTime(Carbon $time):string
    {
        $month = $time->month;
        $months = [
            1 => 'янв',
            2 => 'фев',
            3 => 'мар',
            4 => 'апр',
            5 => 'май',
            6 => 'июн',
            7 => 'июл',
            8 => 'авг',
            9 => 'сен',
            10 => 'окт',
            11 => 'ноя',
            12 => 'дек'
        ];
        return $this->setAttribute('time',"$time->day $months[$month] $time->year");
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
