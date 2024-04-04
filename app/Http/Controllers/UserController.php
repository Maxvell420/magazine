<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        $title = 'Регистрация на Медуса';
        $styles = 'css/user/create.css';
        return view('user.create',compact(['styles','title']));
    }
    public function login()
    {
        $title = 'Медуса - вход';
        $styles = 'css/user/create.css';
        return view('user.login',compact(['styles','title']));
    }
    public function auth(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('main.dashboard');
        }
        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('main.dashboard');
    }
}
