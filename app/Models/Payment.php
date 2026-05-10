<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Resident;

class Payment extends Model
{
    protected $fillable = [

        'user_id',
        'resident_id',
        'bulan',
        'tahun',
        'ikut_ronda',
        'tanggal_ronda',
        'nominal_ipl',
        'nominal_kas',
        'nominal_denda',
        'total',
        'bukti_bayar',
        'status_verifikasi'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION RESIDENT
    |--------------------------------------------------------------------------
    */

    public function resident()
    {
        return $this->belongsTo(
            Resident::class
        );
    }
}