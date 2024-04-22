<?php

namespace App\Models;

use App\Traits\UsabilityTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,UsabilityTime;
    protected $fillable=['price','quantity','type','name','category_id','subcategory_id','properties'];
    public function loadExternalData()
    {
        $this->getUsabilityTime($this->created_at);
        $this->getPreviewPath();
    }
    public function getPreviewPath()
    {
        $image = $this->images()->first();
        $path = "{$image->path}/{$image->name}";
        $this->setAttribute('preview',$path);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function languages()
    {
        return $this->belongsToMany(Language::class)->withPivot('properties');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function setPreviewInfo()
    {
        
    }
}
