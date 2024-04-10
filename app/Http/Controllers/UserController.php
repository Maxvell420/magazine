<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function auth(Request $request): \Illuminate\Http\RedirectResponse
    {
        $lang = App::getLocale();
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route($lang.'.'.'main.dashboard');
        }
        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout()
    {
        $lang = App::getLocale();
        Auth::logout();
        return redirect()->route($lang.'.'.'main.dashboard');
    }
}
