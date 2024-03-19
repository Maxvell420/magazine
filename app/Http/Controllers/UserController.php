<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\City;
use App\Models\House;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController
{
    public function login()
    {
        return view('user.login');
    }
    public function chats()
    {
        $user = Auth::user();
        $chats = $this->getChats($user);
        return view('user.chats', compact('chats'));
    }
    private function getChats(User $user)
    {
        $user->load(['houses.chats', 'chats']);

        $houseChats = $user->houses->flatMap(function ($house) {
            return $house->chats;
        });
        $userChats = $user->chats;

        return $houseChats->merge($userChats)->unique();
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $service = new DashboardService();
        $houses = $service->getFilteredHouses($request);
        $cities = $service->getCities();
        $values = [
            'city'=> $request->input('city'),
            'rooms'=>$request->input('rooms'),
            'price'=>$request->input('price'),
            'fridge'=>$request->input('fridge'),
            'author'=>$request->input('author'),
            'dishwasher'=>$request->input('dishwasher'),
            'clothWasher'=>$request->input('clothWasher'),
            'balcony'=>$request->input('balcony'),
            'bathroom'=>$request->input('bathroom'),
        ];
        $watchlist = $service->getFavouriteHouses($user);
        return view('user.dashboard',compact(['houses','cities','values','watchlist']));
    }
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function auth(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.dashboard');
        }
        echo Auth::check();
        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }
    public function show(int $user_id = null)
    {
        $service = new DashboardService();
        $user_id = $user_id ?? Auth::user()->id;
        $user = User::find($user_id);
        $user->getUsabilityTime($user->created_at);
        $houses = $user->houses();
        $houses = $service->addUsabilityData($houses);
        $watchlist = $service->getFavouriteHouses($user);
        return view('user.show',compact(['houses','user','watchlist']));
    }
    public function create()
    {
        return view('user.create');
    }
    public function save(Request $request)
    {
        $validated = $request->validate(['name'=>['required'],'password'=>['required']]);
        $validated['password']=Hash::make($validated['password']);
        User::query()->create($validated);
        return $this->auth($request);
    }
    public function houses(User $user = null)
    {
        if (!isset($user)){
            $user = Auth::user();
        }
        $houses = $user->houses()->get();
        return view('user.houses',compact('houses'));
    }
    public function frozen()
    {
        return view('user.frozen');
    }
    public function about()
    {
        return view('user.project');
    }
}
