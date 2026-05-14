<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('account');
    }

    public function update(Request $request)
    {
        $request->validate(

            [
                'email' => [
                    'required',
                    'email:rfc,dns',
                    'unique:users,email,' . auth()->id(),
                ],

                'password' => [
                    'nullable',
                    'min:6',
                    'confirmed',
                ],

            ],

            [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',

                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sama',
            ]

        );

        $user = auth()->user();

        $user->email = $request->email;

        if ($request->filled('password')) {

            $user->password = bcrypt($request->password);

        }

        $user->save();

        return back()->with(
            'success',
            'Akun berhasil diperbarui'
        );
    }
}