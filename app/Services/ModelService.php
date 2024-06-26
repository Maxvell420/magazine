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
    public function setModelProperties(Model $model,string $attribute)
    {
        if ($model->$attribute === null) {
            throw new \Exception(trans('messages.notfound'));
        }
        // Декодирование JSON-строки свойств продукта
        $properties = json_decode($model->$attribute, true);
        // Проверяем, удалось ли декодировать JSON
        if ($properties === null) {
            return $model;
        }
        $additionalProperties = [];
        // Устанавливаем свойства продукта
        foreach ($properties as $property => $value) {
            // Проверяем, есть ли у продукта свойство "name"
            if ($property === 'name') {
                $model->name = $value;
            } else {
                // Добавляем дополнительные свойства продукта в виде массива
                $additionalProperties[$property] = $value;
            }
        }
        // Проверяем, установлено ли имя продукта
        if ($model->name === null) {
            throw new \Exception(trans('messages.notfound'));
        }
        // Если есть дополнительные свойства, устанавливаем их
        if (!empty($additionalProperties)) {
            $model->additional_properties = $additionalProperties;
        }
    }
    public function getPivotPropertiesWithLanguage(Collection $collection,string $column,Language $language)
    {
        $collection->each(function ($item)  use ($column,$language){
            $item->setAttribute($column, $item->languages->where('id','=',$language->id)->pluck('pivot.'.$column)->implode(', '));
        });
        return $collection;
    }
    public function getModelPivotPropertiesWithLanguage(Model $model,string $column,Language $language)
    {
        $model->setAttribute($column,$model->languages->where('id','=',$language->id)->pluck('pivot.'.$column)->implode(', '));
        return $model;
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
