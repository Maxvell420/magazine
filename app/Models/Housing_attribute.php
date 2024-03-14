<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Housing_attribute extends Model
{
    use HasFactory;
    protected $fillable=['house_id','rooms','description','fridge',
        'dishwasher','clothWasher','balcony','bathroom','pledge','infrastructure','author'];
    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
