<?php

namespace App\Models;

use App\Services\CoordinateService;
use App\Traits\FileOperationsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use stdClass;

class House extends Model
{
    use HasFactory,FileOperationsTrait;
    protected $fillable=['user_id','city_id','description','rooms','price','archived'];
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
        if (!$this->photo){
            return $this->coordinate->getMap();
        } else {
            return $this->photo->first()->path;
        }
    }
    public function coordinate()
    {
        return $this->hasOne(Coordinate::class);
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
