<?php

namespace App\Classes;

use App\Models\Coordinate;
use App\Traits\FileOperationsTrait;

class MapDataFetcher
{
    use FileOperationsTrait;
    public function __construct(protected Coordinate $coordinate)
    {}
    public function fetchMap()
    {
        $url = "http://static.maps.2gis.com/1.0?zoom=15&size=500,350&markers=".$this->coordinate->lon.','.$this->coordinate->lat;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $map = curl_exec($curl);
        $path ="maps/".$this->coordinate->house_id;
        $name = $this->coordinate->name.".png";
        $this->createDir($path);
        file_put_contents($path.'/'.$name,$map);
        $this->coordinate->update(['path'=>$path,'name'=>$name]);
    }
}
