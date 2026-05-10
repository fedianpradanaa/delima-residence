<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Resident;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function create()
    {
        /*
        |--------------------------------------------------------------------------
        | DAFTAR BULAN YANG BISA DIBAYAR
        |--------------------------------------------------------------------------
        */

        $availablePeriods = [];

        $monthNames = [

            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        /*
        |--------------------------------------------------------------------------
        | GENERATE PERIODE
        |--------------------------------------------------------------------------
        */

        for ($year = 2026; $year <= 2030; $year++) {

            for ($month = 1; $month <= 12; $month++) {

                /*
                |--------------------------------------------------------------------------
                | SKIP JAN-APRIL 2026
                |--------------------------------------------------------------------------
                */

                if (
                    $year == 2026
                    &&
                    $month < 5
                ) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | CEK SUDAH BAYAR
                |--------------------------------------------------------------------------
                */

                $exists = Payment::where(
                        'resident_id',
                        auth()->user()->resident_id
                    )
                    ->where(
                        'bulan',
                        $month
                    )
                    ->where(
                        'tahun',
                        $year
                    )
                    ->exists();

                /*
                |--------------------------------------------------------------------------
                | JIKA BELUM ADA
                |--------------------------------------------------------------------------
                */

                if (!$exists) {

                    $availablePeriods[] = [

                        'bulan' => $month,

                        'tahun' => $year,

                        'label' =>
                            $monthNames[$month]
                            . ' '
                            . $year,
                    ];
                }
            }
        }

        return view(
            'payments.create',
            compact(
                'availablePeriods'
            )
        );
    }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | SPLIT PERIODE
        |--------------------------------------------------------------------------
        */

        $periode = explode(
            '|',
            $request->periode
        );

        $request->merge([

            'bulan' => $periode[0],

            'tahun' => $periode[1],
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'bulan' => 'required',

            'tahun' => 'required',

            'ikut_ronda' => 'required',

            'bukti_bayar' => 'required|image',
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI TANGGAL RONDA
        |--------------------------------------------------------------------------
        */

        if ($request->ikut_ronda == 1) {

            $request->validate([

                'tanggal_ronda' =>
                    'required|date'

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK DUPLIKAT
        |--------------------------------------------------------------------------
        */

        $exists = Payment::where(
                'resident_id',
                auth()->user()->resident_id
            )
            ->where(
                'bulan',
                $request->bulan
            )
            ->where(
                'tahun',
                $request->tahun
            )
            ->exists();

        if ($exists) {

            return back()->with([

                'error' =>
                    'Pembayaran periode ini sudah ada'

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | IPL DASAR
        |--------------------------------------------------------------------------
        |
        | Jan - Mei 2026 = 75.000
        | Juni 2026 dst  = 55.000
        |
        */

        if (

            $request->tahun == 2026
            &&
            $request->bulan <= 5

        ) {

            $iplDasar = 75000;

        } else {

            $iplDasar = 55000;
        }

        /*
        |--------------------------------------------------------------------------
        | RUKEM
        |--------------------------------------------------------------------------
        |
        | rukem 1 = +0
        | rukem 2 = +5000
        | rukem 3 = +10000
        |
        */

        $rukem = auth()->user()->resident->rukem ?? 1;

        /*
        |--------------------------------------------------------------------------
        | TAMBAHAN RUKEM
        |--------------------------------------------------------------------------
        */

        $tambahanRukem =
            max($rukem - 1, 0) * 5000;

        /*
        |--------------------------------------------------------------------------
        | TOTAL IPL
        |--------------------------------------------------------------------------
        */

        $ipl =
            $iplDasar +
            $tambahanRukem;

        /*
        |--------------------------------------------------------------------------
        | KAS
        |--------------------------------------------------------------------------
        */

        $kas = 5000;

        /*
        |--------------------------------------------------------------------------
        | DENDA
        |--------------------------------------------------------------------------
        */

        $denda = 0;

        if ($request->ikut_ronda == 0) {

            $denda = 20000;
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $total =
            $ipl +
            $kas +
            $denda;

        /*
        |--------------------------------------------------------------------------
        | UPLOAD
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

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

        return back()->with([

            'success' =>
                'Pembayaran berhasil dikirim'

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX ADMIN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->search;

        $bulan = $request->bulan;

        $tahun = $request->tahun;

        /*
        |--------------------------------------------------------------------------
        | PAYMENTS
        |--------------------------------------------------------------------------
        */

        $payments = Payment::with([
                'user.resident'
            ])

            ->when($search, function ($query) use ($search) {

                $query->whereHas('user', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");

                });

            })

            ->when($bulan, function ($query) use ($bulan) {

                $query->where('bulan', $bulan);

            })

            ->when($tahun, function ($query) use ($tahun) {

                $query->where('tahun', $tahun);

            })

            ->latest()

            ->get();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalWarga = Resident::where(
            'status_rumah',
            'DITEMPATI'
        )->count();

        $totalPembayaran = $payments->count();

        $totalPending = $payments
            ->where('status_verifikasi', 'pending')
            ->count();

        $totalKasMasuk = $payments
            ->where('status_verifikasi', 'diterima')
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | CHART
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

        return view(
            'payments.index',
            compact(
                'payments',
                'totalWarga',
                'totalPembayaran',
                'totalPending',
                'totalKasMasuk',
                'search',
                'bulan',
                'tahun',
                'chartData'
            )
        );
    }

    public function verify($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->status_verifikasi = 'diterima';

        $payment->save();

        return back();
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->status_verifikasi = 'ditolak';

        $payment->save();

        return back();
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