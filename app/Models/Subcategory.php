<?php

namespace App\Models;

use App\Traits\UsabilityTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory,UsabilityTime;
    protected $fillable=['name','category_id'];
    public function languages()
    {
        return $this->belongsToMany(Language::class)->withPivot('name');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getPropertyFromPivot(Language $language)
    {
        return $this->languages()->firstWhere('language_id', $language->id)->pivot;
    }
}
