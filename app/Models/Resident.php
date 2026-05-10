<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Payment;

class Resident extends Model
{
    protected $fillable = [

        'alamat',

        'nama',

        'status_rumah'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION USERS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->hasOne(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION PAYMENTS
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        return $this->hasMany(
            Payment::class
        );
    }
}