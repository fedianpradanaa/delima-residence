<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [

        'nama',
        'keterangan',
        'nominal',
        'tanggal',
        'bukti',
        'created_by',

    ];
}