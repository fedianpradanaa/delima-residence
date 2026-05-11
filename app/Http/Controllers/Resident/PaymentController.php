<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function create()
    {
        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN TERAKHIR
        |--------------------------------------------------------------------------
        */

        $lastPayment = Payment::where(
                'resident_id',
                auth()->user()->resident_id
            )
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | START DATE
        |--------------------------------------------------------------------------
        */

        if (!$lastPayment) {

            $startDate = Carbon::create(
                2026,
                5,
                1
            );

        } else {

            $startDate = Carbon::create(
                $lastPayment->tahun,
                $lastPayment->bulan,
                1
            )->addMonth();
        }

        /*
        |--------------------------------------------------------------------------
        | AVAILABLE PERIODS
        |--------------------------------------------------------------------------
        */

        $availablePeriods = [];

        for ($i = 0; $i < 5; $i++) {

            $date = $startDate
                ->copy()
                ->addMonths($i);

            $availablePeriods[] = [

                'bulan' => $date->month,

                'tahun' => $date->year,

                'label' => $date
                    ->translatedFormat('F Y')

            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'payments.create',
            compact('availablePeriods')
        );
    }

    public function store(Request $request)
    {
        $periode = explode(
            '|',
            $request->periode
        );

        $request->merge([

            'bulan' => $periode[0],

            'tahun' => $periode[1],
        ]);

        $request->validate([

            'bulan' => 'required',

            'tahun' => 'required',

            'ikut_ronda' => 'required',

            'bukti_bayar' => 'required|image',
        ]);

        if ($request->ikut_ronda == 1) {

            $request->validate([

                'tanggal_ronda' =>
                    'required|date'

            ]);
        }

        $exists = Payment::where(
                'resident_id',
                auth()->user()->resident_id
            )
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->exists();

        if ($exists) {

            return back()->with([

                'error' =>
                    'Pembayaran periode ini sudah ada'

            ]);
        }

        if (

            $request->tahun == 2026
            &&
            $request->bulan <= 5

        ) {

            $iplDasar = 75000;

        } else {

            $iplDasar = 55000;
        }

        $rukem =
            auth()->user()->resident->rukem ?? 1;

        $tambahanRukem =
            max($rukem - 1, 0) * 5000;

        $ipl =
            $iplDasar +
            $tambahanRukem;

        $kas = 5000;

        $denda = 0;

        if ($request->ikut_ronda == 0) {

            $denda = 20000;
        }

        $total =
            $ipl +
            $kas +
            $denda;

        $file = $request->file(
            'bukti_bayar'
        );

        $filename =
            time()
            . '_'
            . $file->getClientOriginalName();

        $file->move(

            public_path(
                'uploads/payments'
            ),

            $filename

        );

        $path =
            'uploads/payments/'
            . $filename;

        Payment::create([

            'user_id' =>
                auth()->id(),

            'resident_id' =>
                auth()->user()->resident_id,

            'bulan' =>
                $request->bulan,

            'tahun' =>
                $request->tahun,

            'ikut_ronda' =>
                $request->ikut_ronda,

            'tanggal_ronda' =>
                $request->tanggal_ronda,

            'nominal_ipl' =>
                $ipl,

            'nominal_kas' =>
                $kas,

            'nominal_denda' =>
                $denda,

            'total' =>
                $total,

            'bukti_bayar' =>
                $path,

            'status_verifikasi' =>
                'pending',
        ]);

        session()->flash(
            'success',
            'Pembayaran berhasil dikirim'
        );

        return redirect('/payment-history');
    }

    public function history()
    {
        $payments = Payment::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->get();

        return view(
            'payments.history',
            compact('payments')
        );
    }
}