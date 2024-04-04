<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['payed','status','products','delivery_id','user_id','price','filepath','filename'];
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
