<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('name');
    }
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class)->withPivot('name');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
