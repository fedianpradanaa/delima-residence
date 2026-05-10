<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            [
                'nama' => 'HUDA MUSTAKIM',
                'alamat' => 'A1',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'FEDIAN TEGAR PRADANA',
                'alamat' => 'A2',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A3',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A4',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => 'CAHYA ABDUL AZIZ',
                'alamat' => 'A5',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'RAHMAT SEPRIYAN',
                'alamat' => 'A6',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A7',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => 'YATI HARYATI',
                'alamat' => 'A8',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'DADAN WAHYU KUSUMAH',
                'alamat' => 'A9',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'DAVID',
                'alamat' => 'A10',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'BANGUN NOVIANTO',
                'alamat' => 'A11',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'SETYO UONI ATAKA',
                'alamat' => 'A12',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'ITA INDRAYANTI',
                'alamat' => 'A13',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'DESTI',
                'alamat' => 'A14',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A15',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A16',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A17',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A18',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A19',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'A20',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => 'ANTONY HALIM',
                'alamat' => 'B1',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'TOBIIN',
                'alamat' => 'B2',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'PURWANTO',
                'alamat' => 'B3',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'LINGGA PRAHEKSA',
                'alamat' => 'B4',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'GURUH SAPUTRA',
                'alamat' => 'B5',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'TAUFIK FADILLAH',
                'alamat' => 'B6',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'B7',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => 'NIKODEMUS',
                'alamat' => 'B8',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'HARU AGUSTINO',
                'alamat' => 'B9',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'YUNI WIJIYATI',
                'alamat' => 'B10',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'B11',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => 'JAJANG ROBBY',
                'alamat' => 'B12',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'NAOVAL AZIZ ANGGORO',
                'alamat' => 'B13',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'I MADE SUYANDIKA',
                'alamat' => 'B14',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => 'PIKI FIRMANSYAH',
                'alamat' => 'B15',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'B16',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => 'YULIS TRIYONO',
                'alamat' => 'B17',
                'status_rumah' => 'DITEMPATI'
            ],

            [
                'nama' => null,
                'alamat' => 'B18',
                'status_rumah' => 'TIDAK DITEMPATI'
            ],

            [
                'nama' => 'RADEN',
                'alamat' => 'B19',
                'status_rumah' => 'DITEMPATI'
            ],

        ];

        foreach ($data as $item) {

            Resident::create($item);
        }
    }
}