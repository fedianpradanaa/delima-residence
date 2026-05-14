@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-3xl font-bold tracking-tight text-teal-700">

            Riwayat Pembayaran

        </h1>

        <p class="text-slate-500 mt-2">

            Data pembayaran IPL & kas cluster

        </p>

    </div>

    <!-- Profile -->
    <div class="mb-6 rounded-3xl border border-white/40 bg-gradient-to-br from-teal-500 to-teal-700 p-6 text-white shadow-xl shadow-teal-500/20">

        <div class="flex items-center justify-between flex-wrap gap-4">

            <div>

                <div class="text-xl font-bold">

                    {{ auth()->user()->name }}

                </div>

                <div class="text-teal-100">

                    Blok
                    {{ auth()->user()->resident->alamat }}

                </div>

            </div>

        </div>

    </div>

    <!-- Card -->
    <div class="overflow-hidden rounded-2xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] text-sm md:text-base">

                <!-- Head -->
                <thead class="bg-teal-50/80 backdrop-blur">

                    <tr>

                        <th class="p-4 text-left">
                            Periode
                        </th>

                        <th class="p-4 text-left">
                            IPL
                        </th>

                        <th class="p-4 text-left">
                            Kas
                        </th>

                        <th class="p-4 text-left">
                            Denda
                        </th>

                        <th class="p-4 text-left">
                            Total
                        </th>

                        <th class="p-4 text-left">
                            Status
                        </th>

                        <th class="p-4 text-left">
                            Bukti
                        </th>

                    </tr>

                </thead>

                <!-- Body -->
                <tbody>

                    @forelse($payments as $payment)

                    <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

                        <!-- Periode -->
                        <td class="p-4 font-semibold">

                            {{ \Carbon\Carbon::create()
                                ->month($payment->bulan)
                                ->translatedFormat('F') }}

                            {{ $payment->tahun }}

                        </td>

                        <!-- IPL -->
                        <td class="p-4">

                            Rp {{ number_format($payment->nominal_ipl) }}

                        </td>

                        <!-- Kas -->
                        <td class="p-4">

                            Rp {{ number_format($payment->nominal_kas) }}

                        </td>

                        <!-- Denda -->
                        <td class="p-4">

                            Rp {{ number_format($payment->nominal_denda) }}

                        </td>

                        <!-- Total -->
                        <td class="p-4 text-base font-bold text-teal-700">

                            Rp {{ number_format($payment->total) }}

                        </td>

                        <!-- Status -->
                        <td class="p-4">

                            @if($payment->status_verifikasi == 'pending')

                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">

                                    Pending

                                </span>

                            @elseif($payment->status_verifikasi == 'diterima')

                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                                    Diterima

                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">

                                    Ditolak

                                </span>

                            @endif

                        </td>

                        <!-- Bukti -->
                        <td class="p-4">

                            <a
                                href="/{{ $payment->bukti_bayar }}"
                                target="_blank"
                                class="inline-flex rounded-xl bg-blue-50 px-3 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-100"
                            >

                                Lihat Bukti

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="7"
                            class="p-10 text-center text-slate-400"
                        >

                            Belum ada pembayaran

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            <!-- Pagination -->
            <div class="border-t border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-5">

                <div class="flex items-center justify-between flex-wrap gap-4">

                    <div class="text-sm text-slate-500">

                        Menampilkan
                        <span class="font-semibold text-slate-700">
                            {{ $payments->firstItem() }}
                        </span>
                        -
                        <span class="font-semibold text-slate-700">
                            {{ $payments->lastItem() }}
                        </span>
                        dari
                        <span class="font-semibold text-slate-700">
                            {{ $payments->total() }}
                        </span>
                        pembayaran

                    </div>

                    {{ $payments->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))

<script>

document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({

        icon: 'success',

        title: 'Berhasil',

        text: '{{ session('success') }}',

        confirmButtonColor: '#10b981',

    });

});

</script>

@endif

@endsection