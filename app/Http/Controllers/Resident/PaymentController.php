<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
        ->whereIn('status_verifikasi', ['pending', 'diterima'])    
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
        Log::info('PAYMENT STORE START', [

            'user_id' => auth()->id(),

            'resident_id' =>
                auth()->user()->resident_id,

            'periode' =>
                $request->periode,
        ]);
        
        $request->validate([

            'periode' => 'required'
        ]);

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

            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,webp,heic,heif|max:10240',
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

            return back()
                ->withInput()
                ->with([

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

        if (!$request->hasFile('bukti_bayar')) {

            return back()
                ->withInput()
                ->with([


                'error' =>
                    'File tidak ditemukan'
            ]);
        }

        $file = $request->file(
            'bukti_bayar'
        );

        if (!$file->isValid()) {

            return back()
                ->withInput()
                ->with([

                'error' =>
                    'Upload file gagal'
            ]);
        }

        $filename =
            time()
            . '_'
            . uniqid()
            . '.'
            . $file->getClientOriginalExtension();

        if (
            !file_exists(
                public_path('uploads/payments')
            )
        ) {

            mkdir(

                public_path(
                    'uploads/payments'
                ),

                0777,

                true
            );
        }

        $file->move(

            public_path(
                'uploads/payments'
            ),

            $filename

        );

        $path =
            'uploads/payments/'
            . $filename;

        $payment = Payment::create([

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

        /*
        |--------------------------------------------------------------------------
        | TELEGRAM NOTIFICATION
        |--------------------------------------------------------------------------
        */

        try {

            $resident =
                auth()->user()->resident;

            $message =
"🔔 PEMBAYARAN IPL BARU

👤 Nama:
{$resident->nama}

🏠 Alamat:
{$resident->alamat}

📅 Periode:
" . Carbon::create()
        ->month((int) $request->bulan)
        ->translatedFormat('F')
        . " {$request->tahun}

💰 Total:
Rp " . number_format($total) . "

📌 Status:
MENUNGGU VERIFIKASI";

            $response = Http::timeout(10)->post(

                'https://api.telegram.org/bot'
                . env('TELEGRAM_BOT_TOKEN')
                . '/sendMessage',

                [

                    'chat_id' =>
                        env('TELEGRAM_CHAT_ID'),

                    'text' =>
                        $message,
                ]

            );

            Log::info('TELEGRAM RESPONSE', [

                'response' =>
                    $response->json()

            ]);

        } catch (\Exception $e) {

            Log::error(
                'TELEGRAM ERROR',
                [
                    'message' =>
                        $e->getMessage()
                ]
            );
        }

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
            ->paginate(10)
            ->withQueryString();

        return view(
            'payments.history',
            compact('payments')
        );
    }
}
