<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => 'required|string',
            'password'  => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session(['login_time' => now()->timezone('Asia/Jakarta')->format('l, d F Y — H:i:s')]);
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'user_name' => 'Kredensial tidak valid.',
        ])->onlyInput('user_name');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
