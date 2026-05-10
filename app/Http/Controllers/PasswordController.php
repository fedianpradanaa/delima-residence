<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([

            'password_lama' => 'required',

            'password_baru' => 'required|min:6',

            'konfirmasi_password' => 'required|same:password_baru',
        ]);

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | CHECK PASSWORD LAMA
        |--------------------------------------------------------------------------
        */

        if (! Hash::check(
            $request->password_lama,
            $user->password
        )) {

            return back()->with([
                'error' => 'Password lama salah'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        $user->password = $request->password_baru;

        $user->save();

        return back()->with([
            'success' => 'Password berhasil diubah'
        ]);
    }
}