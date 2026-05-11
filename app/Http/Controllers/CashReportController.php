<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Expense;

class CashReportController extends Controller
{
    public function index()
    {
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
        | TOTAL PENGELUARAN
        |--------------------------------------------------------------------------
        */

        $totalPengeluaran = Expense::sum(
            'nominal'
        );

        /*
        |--------------------------------------------------------------------------
        | SALDO KAS CLUSTER
        |--------------------------------------------------------------------------
        */

        $saldoKas =
            $totalKas -
            $totalPengeluaran;

        /*
        |--------------------------------------------------------------------------
        | CHART PEMASUKAN
        |--------------------------------------------------------------------------
        */

        $chartData = Payment::selectRaw(
            '
            CONCAT(
                tahun,
                "-",
                LPAD(bulan,2,"0")
            ) as bulan_angka,

            SUM(nominal_kas) as kas
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
        | DATA
        |--------------------------------------------------------------------------
        */

        $payments = Payment::where(
                'status_verifikasi',
                'diterima'
            )
            ->latest()
            ->take(20)
            ->get();

        $expenses = Expense::latest()
            ->take(20)
            ->get();


                /*
        |--------------------------------------------------------------------------
        | SUMMARY BULANAN
        |--------------------------------------------------------------------------
        */

        $monthlySummary = [];

        $months = Payment::selectRaw(
            '
            tahun,
            bulan
            '
        )
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

        foreach ($months as $month) {

            $pemasukan = Payment::where(
                    'status_verifikasi',
                    'diterima'
                )
                ->where('tahun', $month->tahun)
                ->where('bulan', $month->bulan)
                ->sum('nominal_kas');

            $pengeluaran = Expense::whereYear(
                    'tanggal',
                    $month->tahun
                )
                ->whereMonth(
                    'tanggal',
                    $month->bulan
                )
                ->sum('nominal');

            $saldo =
                $pemasukan -
                $pengeluaran;

            $monthlySummary[] = [

                'bulan' =>
                    $month->bulan,

                'tahun' =>
                    $month->tahun,

                'pemasukan' =>
                    $pemasukan,

                'pengeluaran' =>
                    $pengeluaran,

                'saldo' =>
                    $saldo

            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'cash-report.index',
            compact(
                'totalIPL',
                'totalKas',
                'totalDenda',
                'totalPengeluaran',
                'saldoKas',
                'chartData',
                'payments',
                'expenses',
                'monthlySummary'
            )
        );
    }
}