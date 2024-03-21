<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;
    protected $fillable=['user_id','house_id'];
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function house()
    {
        return $this->belongsTo(House::class);
    }
    public function newMessages()
    {
        return $this->messages()->where('checked', '=', 0)->get();
    }
    public function getLatestMessage()
    {
        if (empty($this->messages)) {
            $this->load('messages');
        }
        return $this->messages()->orderByDesc('created_at')->first();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getChatWith(House $house)
    {
        $user = Auth::user();
        if ($house->user_id!=$user->id){
            return $house->user;
        } else{
            return $this->user;
        }
    }
}
