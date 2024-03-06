<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function firstOrCreateChat(House $house)
    {
        $chat = $house->chats()->firstOrCreate(['user_id'=>Auth::user()->id],['user_id'=>Auth::user()->id]);
        $chat->load('messages.user');
        return $chat;
    }
    public function messagesCheck(Chat $chat)
    {
        return $chat->messages->isNotEmpty();
    }
    public function MarkAsReaded(Chat $chat)
    {
        if ($chat->messages->isNotEmpty()){
            $message = $chat->getLatestMessage();
            if ($message->user_id!=Auth::user()->id){
                $chat->messages()->update(['checked'=>true]);
            }
        }
    }
    public function messageCreate(Request $request, Chat $chat)
    {
        $message=$chat->messages()->create(['user_id'=>Auth::user()->id,'text'=>$request->input('text')]);
        if ($chat->house()->first()->user_id == Auth::user()->id){
            $message->update(['checked'=>1]);
        }
    }
}
