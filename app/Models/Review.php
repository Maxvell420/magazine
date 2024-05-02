<?php

namespace App\Models;

use App\Traits\UsabilityTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory,UsabilityTime;
    protected $fillable = ['text','user_id','product_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function setTime()
    {
        $this->getUsabilityTime($this->created_at);
    }
}
