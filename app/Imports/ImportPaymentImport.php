<?php

namespace App\Imports;

use App\Models\ImportPayment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPaymentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ImportPayment([

            'alamat' => $row['alamat'] ?? null,

            'nama' => $row['nama'] ?? null,

            'status_rumah' => $row['status_rumah'] ?? null,

            'tanggal' => isset($row['tanggal'])
                ? date('Y-m-d', strtotime($row['tanggal']))
                : null,

            'bulan' => $row['bulan'] ?? null,

            'type_iuran' => $row['type_iuran'] ?? null,

            'nominal' => $row['nominal'] ?? 0,

            'temp_status' => $row['temp_status'] ?? null,

            'status' => $row['status'] ?? null,

            'bulan_angka' => $row['bulan_angka'] ?? null,

            'remark' => $row['remark'] ?? null,
        ]);
    }
}