<?php

namespace App\Models;

use App\Classes\GeoEncoder;
use App\Classes\MapDataFetcher;
use App\Traits\FileOperationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory,FileOperationsTrait;
    protected $fillable=['house_id','city_id','street','building','lon','lat','path','name'];
    public function downloadMap()
    {
        $matFetcher = new MapDataFetcher($this);
        $matFetcher->fetchMap();
    }
    public function getAddress()
    {
        return "{$this->city->name} $this->street $this->building";
    }
    public function getMap()
    {
        return $this->path.'/'.$this->name;
    }
    public function house()
    {
        return $this->belongsTo(House::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
