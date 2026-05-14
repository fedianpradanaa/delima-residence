<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Expense;
use App\Models\Resident;

use Carbon\Carbon;

class SummaryCashReportController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        /*
        |--------------------------------------------------------------------------
        | QUERY PAYMENT
        |--------------------------------------------------------------------------
        */

        $payments = Payment::query();

        if ($bulan) {

            $payments->where(
                'bulan',
                $bulan
            );
        }

        if ($tahun) {

            $payments->where(
                'tahun',
                $tahun
            );
        }

        $payments = $payments
            ->where(
                'status_verifikasi',
                'diterima'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | QUERY EXPENSE
        |--------------------------------------------------------------------------
        */

        $expenses = Expense::query();

        if ($bulan) {

            $expenses->whereMonth(
                'tanggal',
                $bulan
            );
        }

        if ($tahun) {

            $expenses->whereYear(
                'tanggal',
                $tahun
            );
        }

        $expenses = $expenses->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARD
        |--------------------------------------------------------------------------
        */

        $totalWargaBayar =
            $payments
                ->pluck('resident_id')
                ->unique()
                ->count();

        $totalIPL =
            $payments->sum(
                'nominal_ipl'
            );

        $totalKas =
            $payments->sum(
                'nominal_kas'
            );

        $totalDenda =
            $payments->sum(
                'nominal_denda'
            );

        $totalPengeluaran =
            $expenses->sum(
                'nominal'
            );

        $saldo =
            (
                $totalIPL
                + $totalKas
                + $totalDenda
            )
            -
            $totalPengeluaran;

        /*
        |--------------------------------------------------------------------------
        | GROUP DATA
        |--------------------------------------------------------------------------
        */

        $grouped = $payments
            ->groupBy(function ($item) {

                return
                    $item->bulan
                    . '-'
                    . $item->tahun;
            });

        /*
        |--------------------------------------------------------------------------
        | SUMMARY PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $summaryPerBulan = [];

        foreach ($grouped as $key => $items) {

            $summaryPerBulan[] = [

                'periode' =>

                    Carbon::create()
                        ->month(
                            $items->first()->bulan
                        )
                        ->translatedFormat('F')

                    . ' '

                    . $items->first()->tahun,

                'warga' =>

                    $items
                        ->pluck('resident_id')
                        ->unique()
                        ->count(),

                'ipl' =>

                    $items->sum(
                        'nominal_ipl'
                    ),

                'kas' =>

                    $items->sum(
                        'nominal_kas'
                    ),

                'denda' =>

                    $items->sum(
                        'nominal_denda'
                    ),

                'total' =>

                    $items->sum(
                        'total'
                    ),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | LAPORAN RT
        |--------------------------------------------------------------------------
        */

        $laporanRT = [];

        foreach ($grouped as $key => $items) {

            $bulanData =
                (int)
                $items->first()->bulan;

            $tahunData =
                (int)
                $items->first()->tahun;

            $totalRT = 0;

            foreach ($items as $payment) {

                $nominalRT = 0;

                /*
                |--------------------------------------------------------------------------
                | JANUARI - APRIL 2026
                |--------------------------------------------------------------------------
                */

                if (
                    $tahunData == 2026
                    &&
                    $bulanData >= 1
                    &&
                    $bulanData <= 4
                ) {

                    if (
                        $payment->nominal_ipl == 75000
                    ) {

                        $nominalRT = 30000;
                    }

                    elseif (
                        $payment->nominal_ipl == 80000
                    ) {

                        $nominalRT = 35000;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | MEI 2026
                |--------------------------------------------------------------------------
                */

                elseif (
                    $tahunData == 2026
                    &&
                    $bulanData == 5
                ) {

                    $resident = Resident::find(
                        $payment->resident_id
                    );

                    $rukem =
                        $resident->rukem ?? 1;

                    $nominalRT = 55000;

                    if ($rukem > 1) {

                        $nominalRT += 5000;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | JUNI DAN SETERUSNYA
                |--------------------------------------------------------------------------
                */

                else {

                    $nominalRT =
                        $payment->nominal_ipl;
                }

                $totalRT += $nominalRT;
            }

            $laporanRT[] = [

                'periode' =>

                    Carbon::create()
                        ->month($bulanData)
                        ->translatedFormat('F')

                    . ' '

                    . $tahunData,

                'warga' =>

                    $items
                        ->pluck('resident_id')
                        ->unique()
                        ->count(),

                'total_rt' =>

                    $totalRT,

                'denda' =>
                    $items->sum('nominal_denda'),
            ];
        }

        $belumBayar = [];

            $residents = Resident::where(
                    'status_rumah',
                    'DITEMPATI'
                )
                ->orderBy('alamat')
                ->get();

            foreach ($residents as $resident) {

                /*
                |--------------------------------------------------------------------------
                | TANGGAL MASUK
                |--------------------------------------------------------------------------
                */

                if (!$resident->tanggal_masuk) {
                    continue;
                }

                $tanggalMasuk =
                    Carbon::parse(
                        $resident->tanggal_masuk
                    );

                /*
                |--------------------------------------------------------------------------
                | FILTER BULAN TAHUN
                |--------------------------------------------------------------------------
                */

                $bulanCek =
                    $bulan
                    ? (int) $bulan
                    : now()->month;

                $tahunCek =
                    $tahun
                    ? (int) $tahun
                    : now()->year;

                /*
                |--------------------------------------------------------------------------
                | JIKA BELUM TINGGAL SAAT PERIODE INI
                |--------------------------------------------------------------------------
                */

                if (

                    $tanggalMasuk->year > $tahunCek

                    ||

                    (

                        $tanggalMasuk->year == $tahunCek
                        &&
                        $tanggalMasuk->month > $bulanCek

                    )

                ) {

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | CEK PEMBAYARAN
                |--------------------------------------------------------------------------
                */

                $sudahBayar = Payment::where(
                        'resident_id',
                        $resident->id
                    )
                    ->where(
                        'bulan',
                        $bulanCek
                    )
                    ->where(
                        'tahun',
                        $tahunCek
                    )
                    ->where(
                        'status_verifikasi',
                        'diterima'
                    )
                    ->exists();

                /*
                |--------------------------------------------------------------------------
                | BELUM BAYAR
                |--------------------------------------------------------------------------
                */

                if (!$sudahBayar) {

                    $belumBayar[] = [

                        'nama' =>
                            $resident->nama,

                        'alamat' =>
                            $resident->alamat,

                        'periode' =>

                            Carbon::create()
                                ->month($bulanCek)
                                ->translatedFormat('F')

                            . ' '

                            . $tahunCek,

                        'status' =>
                            'BELUM BAYAR',
                    ];
                }
            }

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'summary-report.index',

            compact(
                'summaryPerBulan',
                'laporanRT',
                'belumBayar',
                'totalWargaBayar',
                'totalIPL',
                'totalKas',
                'totalDenda',
                'totalPengeluaran',
                'saldo',
                'bulan',
                'tahun'
            )
        );
    }
}