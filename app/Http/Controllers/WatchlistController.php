<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use App\Services\WatchlistService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function __construct(protected WatchlistService $watchlistService)
    {}

    public function add(string $id)
    {
        $user = Auth::user();
        $user = $this->watchlistService->addFavourite($id,$user);
        $user->save();
        return redirect()->back();
    }
    public function show()
    {
        $user = Auth::user();
        $watchlist=$user->getWatchlist();
        $houses = House::query()->find($watchlist);
        return view('house.watchlist',compact('houses'));
    }
    public function remove(string $id)
    {
        $user = Auth::user();
        $user = $this->watchlistService->removeFavourite($id,$user);
        $user->save();
        return redirect()->back();
    }
}
