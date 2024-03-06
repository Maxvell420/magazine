<?php

namespace App\Services;

/*
 *
 */

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WatchlistService
{
    public function removeFavourite(string|int $id, User $user): User
    {
        $watchlist = $user->getWatchlist();
        $ids = $this->watchlistFilter($watchlist,$id);
        $user->favourites = $ids;
        return $user;
    }
    public function addFavourite(string|int $id, User $user): User
    {
        $watchlist = $user->getWatchlist();
        $ids = $this->watchlistFilter($watchlist,$id);
        $user->favourites = $ids.",$id";
        return $user;
    }
    /*
     * Фильтрует избранное и возвращает все значения из массива без переданного id
     */
    private function watchlistFilter(array $watchlist,string|int $id)
    {
        $watchlist = array_filter($watchlist,function ($value) use ($id){
            return $value != $id;
        });
        return implode(',',$watchlist);
    }
}
