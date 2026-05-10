<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Resident;
use App\Models\Payment;
use App\Models\ImportPayment;

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
        | PAYMENT REALTIME
        |--------------------------------------------------------------------------
        */

        $payments = Payment::with([
                'user.resident'
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
            ->pluck('user.resident_id')
            ->unique()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | BELUM BAYAR
        |--------------------------------------------------------------------------
        */

        $belumBayar = $totalWarga - $sudahBayar;

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
        | TOTAL PEMASUKAN LEGACY
        |--------------------------------------------------------------------------
        */

        $legacyPemasukan = ImportPayment::where(
            'bulan_angka',
            '<=',
            '2026-04'
        )->sum('nominal');

        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMASUKAN REALTIME
        |--------------------------------------------------------------------------
        */

        $realtimePemasukan = Payment::where(
                'status_verifikasi',
                'diterima'
            )
            ->where(function ($query) {

                $query->where('tahun', '>', 2026)

                      ->orWhere(function ($q) {

                          $q->where('tahun', 2026)
                            ->where('bulan', '>=', 5);

                      });

            })
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMASUKAN
        |--------------------------------------------------------------------------
        */

        $totalPemasukan =
            $legacyPemasukan +
            $realtimePemasukan;

        /*
        |--------------------------------------------------------------------------
        | CHART DATA
        |--------------------------------------------------------------------------
        */

        $chartData = [];

        /*
        |--------------------------------------------------------------------------
        | CHART LEGACY
        |--------------------------------------------------------------------------
        */

        $legacyChart = ImportPayment::selectRaw(
            '
            bulan_angka,
            SUM(nominal) as total
            '
        )
        ->where(
            'bulan_angka',
            '<=',
            '2026-04'
        )
        ->groupBy('bulan_angka')
        ->orderBy('bulan_angka')
        ->get();

        foreach ($legacyChart as $item) {

            $chartData[] = [

                'bulan_angka' => $item->bulan_angka,

                'total' => $item->total
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | CHART REALTIME
        |--------------------------------------------------------------------------
        */

        $realtimeChart = Payment::selectRaw(
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
        ->where(function ($query) {

            $query->where('tahun', '>', 2026)

                  ->orWhere(function ($q) {

                      $q->where('tahun', 2026)
                        ->where('bulan', '>=', 5);

                  });

        })
        ->groupBy(
            'tahun',
            'bulan'
        )
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

        foreach ($realtimeChart as $item) {

            $chartData[] = [

                'bulan_angka' => $item->bulan_angka,

                'total' => $item->total
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SORT CHART
        |--------------------------------------------------------------------------
        */

        usort($chartData, function ($a, $b) {

            return strcmp(
                $a['bulan_angka'],
                $b['bulan_angka']
            );

        });

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
                'totalPemasukan',
                'chartData'
            )
        );
    }
}