<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    public function subcategory()
    {
        return $this->hasOne(Subcategory::class);
    }
    public function language()
    {
        return $this->belongsToMany(Language::class);
    }
    public function getPropertyFromPivot(Language $language,string $propertyName)
    {
        return $this->language()->firstWhere('language_id', 1)->pivot->$propertyName;
    }
}
