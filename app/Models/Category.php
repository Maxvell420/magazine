<?php

namespace App\Models;

use App\Traits\UsabilityTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, UsabilityTime;
    protected $fillable=['name'];
    public function subcategory()
    {
        return $this->hasOne(Subcategory::class);
    }
    public function languages()
    {
        return $this->belongsToMany(Language::class)->withPivot(['name']);
    }
    public function getPropertiesFromPivot(Language $language)
    {
        return $this->languages()->firstWhere('language_id', $language->id)->pivot;
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
