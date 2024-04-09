<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ModelService
{
    public function getAllRecords(Model $class,string|array $column = null):Collection
    {
        $column=$column??['*'];
        return $class::all($column);
    }

    public function getRecords(Model $class, array $ids, string|array $column = null):Collection
    {
        $column=$column??['*'];
        return $class::query()->whereIn('id',$ids)->get($column);
    }
    public function getRecordsManyToLanguage(Model $model,Language $language):Collection
    {
        return $model->whereHas('languages', function ($query) use ($language) {
            $query->where('language_id', $language->id);
        })->get();
    }
    public function getPivotPropertiesWithLanguage(Collection $collection)
    {
        $collection->each(function ($item) {
            $item->setAttribute('name', $item->languages->pluck('pivot.name')->implode(', '));
        });
        return $collection;
    }
    public function getRecord(Model $class, int|string $id, string|array $column = null):Model
    {
        if ($column){
            return $class::query()->find($id,$column);
        }
        return $class::query()->find($id);
    }
    public function flattenCollection(Collection $collection,$keys):array
    {
        $array = $collection->toArray();
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
