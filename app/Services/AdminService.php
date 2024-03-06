<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\House;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public function getUsersWithNewHousesByDate(string $date = null):Collection
    {
        $newHouses = $this->getNewHousesByDate($date);
        return $this->setCounterInCollection($newHouses);
    }
    public function getFrozenUsers(): \Illuminate\Database\Eloquent\Collection|array
    {
        return User::query()->where('frozen','=',1)->get()->load('complaints');
    }
    /*
     *  setCounterInCollection для статистики число сколько у юзера новых чатов или обьявлений
     */
    private function setCounterInCollection(Collection $collection): Collection
    {
        $users = collect();

        foreach ($collection as $item) {
            $user = $item->user;
            $counter = $user->counter ?? 0;
            $user->counter = $counter + 1;
            $users->put($user->id, $user);
        }
        return $users;
    }
    private function getNewChatsByDate(string $date = null)
    {
        if (!isset($date)){
            $date=now()->toDateString();
        }
        return Chat::query()->where(DB::raw('DATE(created_at)'),'=',$date)->with('user')->has('messages')->get();
    }
    public function getUsersWithNewChatsByDate(string $date = null):Collection
    {
        $newChats = $this->getNewChatsByDate($date);
        return $this->setCounterInCollection($newChats);
    }
    private function getNewHousesByDate(string $date = null)
    {
        if (!isset($date)){
            $date=now()->toDateString();
        }
        return House::query()->where(DB::raw('DATE(created_at)'),'=',$date)->with('user')->get();
    }
    public function houseDelete(House $house)
    {
        $user = Auth::user();
        if ($user->id == $house->user_id or $user->role_id>1){
            $house->delete();
        }
    }
    public function banUser(User $user)
    {
        $houses = $user->houses();
        foreach ($houses->get() as $house){
            $house->photosFileDelete();
            $house->coordinateFileDelete();
        }
        $user->complaints()->delete();
        $user->houses()->delete();
        $user->update(['banned'=>1,'frozen'=>0]);
    }
    public function userUnfreeze(User $user)
    {
        $user->complaints()->delete();
        $user->update(['frozen'=>0]);
    }
}
