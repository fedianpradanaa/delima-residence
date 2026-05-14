<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Resident;
use App\Models\User;

class ResidentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $residents = Resident::with('user')
            ->orderBy('alamat')
            ->get();

        return view(
            'residents.index',
            compact('residents')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $resident = Resident::with('user')
            ->findOrFail($id);

        return view(
            'residents.edit',
            compact('resident')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $resident = Resident::with('user')
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'alamat' => 'required',

            'nama' => 'nullable',

            'status_rumah' => 'required',

            'rukem' => 'required|numeric|min:1',

            'email' => 'nullable|email',

            'username' => 'nullable',

            'is_active' => 'required',

            'nomor_hp' => 'nullable|string|max:20',

            'tanggal_masuk' => 'nullable|date',

            'tanggal_keluar' => 'nullable|date',
        ]);

        /*
        |--------------------------------------------------------------------------
        | FORMAT NOMOR HP
        |--------------------------------------------------------------------------
        */

        $nomorHp = null;

        if ($request->nomor_hp) {

            $nomorHp =
                '62' .
                ltrim(
                    $request->nomor_hp,
                    '0'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TANGGAL KELUAR
        |--------------------------------------------------------------------------
        */

        $tanggalKeluar =
            $request->tanggal_keluar;

        /*
        |--------------------------------------------------------------------------
        | JIKA DITEMPATI
        |--------------------------------------------------------------------------
        */

        if (
            $request->status_rumah
            == 'DITEMPATI'
        ) {

            $tanggalKeluar = null;
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK DITEMPATI
        |--------------------------------------------------------------------------
        */

        if (
            $request->status_rumah
            == 'TIDAK DITEMPATI'
            &&
            !$tanggalKeluar
        ) {

            $tanggalKeluar =
                now()->toDateString();
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE RESIDENT
        |--------------------------------------------------------------------------
        */

        $resident->update([

            'alamat' =>
                strtoupper($request->alamat),

            'nama' =>
                strtoupper($request->nama),

            'status_rumah' =>
                $request->status_rumah,

            'rukem' =>
                $request->rukem,

            'nomor_hp' =>
                $nomorHp,

            'tanggal_masuk' =>
                $request->tanggal_masuk,

            'tanggal_keluar' =>
                $tanggalKeluar,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE USER
        |--------------------------------------------------------------------------
        */

        if ($resident->user) {

            /*
            |--------------------------------------------------------------------------
            | ADMIN ID TIDAK BISA NONAKTIF
            |--------------------------------------------------------------------------
            */

            $isActive =
                $request->is_active;

            if (
                $resident->user->id == 1
            ) {

                $isActive = 1;
            }

            $resident->user->update([

                'name' =>
                    strtoupper($request->nama),

                'email' =>
                    $request->email,

                'username' =>
                    $request->username,

                'is_active' =>
                    $isActive,
            ]);
        }

        return redirect(
            '/residents'
        )->with(

            'success',
            'Data warga berhasil diupdate'
        );
    }
}