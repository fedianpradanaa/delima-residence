<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Resident;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $bulan = $request->bulan ?? now()->month;

        $tahun = $request->tahun ?? now()->year;

        /*
        |--------------------------------------------------------------------------
        | TOTAL WARGA
        |--------------------------------------------------------------------------
        */

        $totalWarga = Resident::where(
            'status_rumah',
            'DITEMPATI'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | RUMAH KOSONG
        |--------------------------------------------------------------------------
        */

        $rumahKosong = Resident::where(
            'status_rumah',
            'TIDAK DITEMPATI'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | PAYMENT BULAN INI
        |--------------------------------------------------------------------------
        */

        $payments = Payment::with([
                'resident'
            ])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUDAH BAYAR
        |--------------------------------------------------------------------------
        */

        $sudahBayar = $payments
            ->where(
                'status_verifikasi',
                'diterima'
            )
            ->pluck('resident_id')
            ->unique()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | BELUM BAYAR
        |--------------------------------------------------------------------------
        */

        $belumBayar =
            max($totalWarga - $sudahBayar, 0);

        /*
        |--------------------------------------------------------------------------
        | TIDAK RONDA
        |--------------------------------------------------------------------------
        */

        $tidakRonda = $payments
            ->where(
                'status_verifikasi',
                'diterima'
            )
            ->where(
                'ikut_ronda',
                0
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL IPL
        |--------------------------------------------------------------------------
        */

        $totalIPL = Payment::where(
                'status_verifikasi',
                'diterima'
            )
            ->sum('nominal_ipl');

        /*
        |--------------------------------------------------------------------------
        | TOTAL KAS
        |--------------------------------------------------------------------------
        */

        $totalKas = Payment::where(
                'status_verifikasi',
                'diterima'
            )
            ->sum('nominal_kas');

        /*
        |--------------------------------------------------------------------------
        | TOTAL DENDA
        |--------------------------------------------------------------------------
        */

        $totalDenda = Payment::where(
                'status_verifikasi',
                'diterima'
            )
            ->sum('nominal_denda');

        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMASUKAN
        |--------------------------------------------------------------------------
        */

        $totalPemasukan = Payment::where(
                'status_verifikasi',
                'diterima'
            )
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | CHART DATA
        |--------------------------------------------------------------------------
        */

        $chartData = Payment::selectRaw(
            '
            CONCAT(
                tahun,
                "-",
                LPAD(bulan,2,"0")
            ) as bulan_angka,

            SUM(total) as total
            '
        )
        ->where(
            'status_verifikasi',
            'diterima'
        )
        ->groupBy(
            'tahun',
            'bulan'
        )
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(
                'payments',
                'totalWarga',
                'rumahKosong',
                'belumBayar',
                'tidakRonda',
                'totalIPL',
                'totalKas',
                'totalDenda',
                'totalPemasukan',
                'chartData',
                'bulan',
                'tahun'
            )
        );
    }
}