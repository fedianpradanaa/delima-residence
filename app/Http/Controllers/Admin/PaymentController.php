<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Resident;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $bulan = $request->bulan;

        $tahun = $request->tahun;

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

            ->paginate(10)

            ->withQueryString();

        $totalWarga = Resident::where(
            'status_rumah',
            'DITEMPATI'
        )->count();

        $totalPembayaran = Payment::count();

        $totalPending = Payment::where(
            'status_verifikasi',
            'pending'
        )->count();

        $totalKasMasuk = Payment::where(
            'status_verifikasi',
            'diterima'
        )->sum('total');

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
                'tahun'
            )
        );
    }

    public function verify($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->status_verifikasi = 'diterima';

        $payment->save();

        session()->flash(
            'success',
            'Pembayaran berhasil disetujui'
        );

        return redirect('/payments');
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->status_verifikasi = 'ditolak';

        $payment->save();

        session()->flash(
            'success',
            'Pembayaran berhasil ditolak'
        );

        return redirect('/payments');
    }
}