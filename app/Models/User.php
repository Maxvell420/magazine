<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'favourites',
        'banned',
        'password',
        'frozen'
    ];
    public function freeze()
    {
        $this->update(['frozen'=>1]);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function getFavourites()
    {
        return $this->favourites;
    }
    public function getWatchlist():array
    {
        $ids = $this->getFavourites();
        $watchlist = explode(',',$ids);
        return array_filter($watchlist,function ($value){
            return $value !== null;
        });
    }
    public function getHousesFromWatchlist(string|int $id)
    {
        $watchlist = $this->getWatchlist();
        return in_array($id,$watchlist);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
    public function sendedComplaints()
    {
        return $this->hasMany(Complaint::class,'sender_id');
    }
    public function houses()
    {
        return $this->hasMany(House::class);
    }
}
