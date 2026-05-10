<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
        {
            $credentials = $request->validate([

                'username' => 'required',

                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {

                $request->session()->regenerate();

                /*
                |--------------------------------------------------------------------------
                | REDIRECT BERDASARKAN ROLE
                |--------------------------------------------------------------------------
                */

                if (auth()->user()->role == 'admin') {

                    return redirect('/dashboard');
                }

                return redirect('/payment');
            }

            return back()->with([

                'error' => 'Username atau password salah'
            ]);
        }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}