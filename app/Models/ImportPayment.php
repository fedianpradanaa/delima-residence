<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportPayment extends Model
{
    protected $fillable = [

        'alamat',

        'nama',

        'status_rumah',

        'tanggal',

        'bulan',

        'type_iuran',

        'nominal',

        'temp_status',

        'status',

        'bulan_angka',

        'remark',
    ];
}