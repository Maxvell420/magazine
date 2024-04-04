<?php

namespace App\Models;

use App\Traits\UsabilityTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UsabilityTime;
    protected $fillable = [
        'name',
        'password',
        'role_id'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
