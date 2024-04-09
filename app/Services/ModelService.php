<?php

namespace App\Services;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ModelService
{
    public function getAllRecords(Model $class,string|array $column = null):Collection
    {
        $column=$column??['*'];
        return $class::all($column);
    }
    public function getAllRecordsJson(Model $class,string|array $column = null): bool|string
    {
        $records = $this->getAllRecords($class,$column)->toArray();
        return json_encode($this->flattenArray($records,$column));
    }
    public function getRecords(Model $class, array $ids, string|array $column = null):Collection
    {
        $column=$column??['*'];
        return $class::query()->whereIn('id',$ids)->get($column);
    }

    public function getRecord(Model $class, int|string $id, string|array $column = null):Model
    {
        if ($column){
            return $class::query()->find($id,$column);
        }
        return $class::query()->find($id);
    }
    private function flattenArray(Array $array,$keys):array
    {
        $result = [];
        $counter = count($array);
        for ($i=0;$i<$counter;$i++){
            foreach ($keys as $item){
                $result[$i][$item]=$array[$i][$item];
            }
        }
        return $result;
    }
}
