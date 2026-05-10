@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-4">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-teal-700">

            Riwayat Pembayaran

        </h1>

        <p class="text-slate-500 mt-2">

            Data pembayaran IPL & kas cluster

        </p>

    </div>

    <!-- Profile -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">

        <div class="flex items-center justify-between flex-wrap gap-4">

            <div>

                <div class="text-xl font-bold">

                    {{ auth()->user()->name }}

                </div>

                <div class="text-slate-500">

                    Blok
                    {{ auth()->user()->resident->alamat }}

                </div>

            </div>

        </div>

    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <!-- Head -->
                <thead class="bg-teal-50">

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

                    <tr class="border-b hover:bg-slate-50">

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
                        <td class="p-4 font-bold text-teal-700">

                            Rp {{ number_format($payment->total) }}

                        </td>

                        <!-- Status -->
                        <td class="p-4">

                            @if($payment->status_verifikasi == 'pending')

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">

                                    Pending

                                </span>

                            @elseif($payment->status_verifikasi == 'diterima')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                    Diterima

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                                    Ditolak

                                </span>

                            @endif

                        </td>

                        <!-- Bukti -->
                        <td class="p-4">

                            <a
                                href="/{{ $payment->bukti_bayar }}"
                                target="_blank"
                                class="text-blue-600 underline"
                            >

                                Lihat Bukti

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="7"
                            class="p-8 text-center text-slate-500"
                        >

                            Belum ada pembayaran

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection