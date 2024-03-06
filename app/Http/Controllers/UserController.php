<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\City;
use App\Models\House;
use App\Models\User;
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
        $houses=House::getHousesFromFilter($request,House::with('city'));
        $houses=$houses->where('archived','!=',true)->whereHas('user',function ($query){
            $query->where('frozen',0);
        })->simplePaginate(6);
        $cities = City::all();
        $values = [
            'city'=> $request->input('city'),
            'rooms'=>$request->input('rooms'),
            'price'=>$request->input('price')
        ];
        $route = 'user.dashboard';
        return view('user.dashboard',compact(['houses','cities','values','route']));
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
    public function show()
    {
        $user = Auth::user();
        $houses = $user->houses()->get();
        return view('user.show',compact('houses'));
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
}
