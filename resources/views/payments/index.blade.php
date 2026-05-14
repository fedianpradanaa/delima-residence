@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-100 py-10">

    <div class="max-w-7xl mx-auto px-4">

        <!-- Header -->
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-teal-700">

                Dashboard Pembayaran

            </h1>

            <p class="text-slate-500 mt-2">

                Verifikasi pembayaran warga Delima Residence

            </p>

        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            <!-- Total Warga -->
            <div class="rounded-[28px] border border-white/60 bg-white/90 p-6 shadow-xl shadow-slate-200/50 backdrop-blur-xl transition hover:-translate-y-1 hover:shadow-2xl">

                <div class="text-teal-600 text-4xl mb-4">
                    🏠
                </div>

                <p class="text-slate-500 text-sm">
                    Total Warga
                </p>

                <h2 class="text-3xl font-bold mt-2">

                    {{ $totalWarga }}

                </h2>

            </div>

            <!-- Total Pembayaran -->
            <div class="rounded-[28px] border border-white/60 bg-white/90 p-6 shadow-xl shadow-slate-200/50 backdrop-blur-xl transition hover:-translate-y-1 hover:shadow-2xl">

                <div class="text-teal-600 text-4xl mb-4">
                    💳
                </div>

                <p class="text-slate-500 text-sm">
                    Total Pembayaran
                </p>

                <h2 class="text-3xl font-bold mt-2">

                    {{ $totalPembayaran }}

                </h2>

            </div>

            <!-- Pending -->
            <div class="rounded-[28px] border border-white/60 bg-white/90 p-6 shadow-xl shadow-slate-200/50 backdrop-blur-xl transition hover:-translate-y-1 hover:shadow-2xl">

                <div class="text-yellow-500 text-4xl mb-4">
                    ⏳
                </div>

                <p class="text-slate-500 text-sm">
                    Pending
                </p>

                <h2 class="text-3xl font-bold mt-2">

                    {{ $totalPending }}

                </h2>

            </div>

            <!-- Kas -->
            <div class="rounded-[28px] border border-white/60 bg-white/90 p-6 shadow-xl shadow-slate-200/50 backdrop-blur-xl transition hover:-translate-y-1 hover:shadow-2xl">

                <div class="text-green-600 text-4xl mb-4">
                    💰
                </div>

                <p class="text-slate-500 text-sm">
                    Total Kas Masuk
                </p>

                <h2 class="text-2xl font-bold mt-2">

                    Rp {{ number_format($totalKasMasuk) }}

                </h2>

            </div>

        </div>

        <!-- Filter -->
        <div class="mb-8 overflow-hidden rounded-[32px] bg-white shadow-sm">

            <!-- Header -->
            <div
                class="border-b border-slate-100 bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-5 text-white"
            >

                <h2 class="text-xl font-bold">

                    Filter Pembayaran

                </h2>

                <p class="mt-1 text-sm text-white/80">

                    Cari dan filter data pembayaran warga

                </p>

            </div>

            <!-- Content -->
            <div class="p-6">

                <form
                    method="GET"
                    action="/payments"
                    class="grid gap-5 md:grid-cols-4"
                >

                    <!-- Search -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-600">

                            Cari Warga

                        </label>

                        <div class="relative">

                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                            >

                                🔍

                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Nama warga..."
                                class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-sm shadow-sm transition focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-teal-100"
                            >

                        </div>

                    </div>

                    <!-- Bulan -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-600">

                            Pilih Bulan

                        </label>

                        <select
                            name="bulan"
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-sm transition focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-teal-100"
                        >

                            <option value="">
                                Semua Bulan
                            </option>

                            @php
                                $bulanList = [
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Agustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember',
                                ];
                            @endphp

                            @foreach($bulanList as $key => $nama)

                                <option
                                    value="{{ $key }}"
                                    {{ $bulan == $key ? 'selected' : '' }}
                                >

                                    {{ $nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Tahun -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-600">

                            Pilih Tahun

                        </label>

                        <select
                            name="tahun"
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-sm transition focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-teal-100"
                        >

                            <option value="">
                                Semua Tahun
                            </option>

                            @for($i = 2026; $i <= 2035; $i++)

                                <option
                                    value="{{ $i }}"
                                    {{ $tahun == $i ? 'selected' : '' }}
                                >

                                    {{ $i }}

                                </option>

                            @endfor

                        </select>

                    </div>

                    <!-- Button -->
                    <div class="flex items-end">

                        <button
                            class="flex h-14 w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-teal-600 to-emerald-600 px-5 font-semibold text-white shadow-lg shadow-teal-500/20 transition hover:scale-[1.02] hover:shadow-xl active:scale-95"
                        >

                            <span>

                                🔎

                            </span>

                            <span>

                                Filter Data

                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-[30px] border border-white/60 bg-white/90 shadow-xl shadow-slate-200/50 backdrop-blur-xl">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <!-- Head -->
                    <thead class="bg-gradient-to-r from-teal-50 to-cyan-50">

                        <tr>

                            <th class="p-4 text-left">
                                Warga
                            </th>

                            <th class="p-4 text-left">
                                Bulan
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

                            <th class="p-4 text-left">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <!-- Body -->
                    <tbody>

                        @forelse($payments as $payment)

                        <tr class="border-b border-slate-100 hover:bg-teal-50/40 transition-all duration-200">

                            <!-- Warga -->
                            <td class="p-4">

                                <div class="font-semibold">

                                    {{ $payment->user->name }}

                                </div>

                                <div class="text-sm text-slate-500">

                                    Blok
                                    {{ $payment->user->resident->alamat }}

                                </div>

                            </td>

                            <!-- Bulan -->
                            <td class="p-4">

                                {{ \Carbon\Carbon::create()
                                    ->month($payment->bulan)
                                    ->translatedFormat('F') }}

                                {{ $payment->tahun }}

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

                                <button
                                    onclick="openModal('/{{ $payment->bukti_bayar }}')"
                                    class="text-blue-600 hover:text-blue-800 underline"
                                >

                                    Preview

                                </button>

                            </td>

                            <!-- Aksi -->
                            <td class="p-4">

                                @if($payment->status_verifikasi == 'pending')

                                    <div class="flex gap-2">

                                        <a
                                            href="/payment/{{ $payment->id }}/verify"
                                            class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-green-500/20 transition hover:-translate-y-0.5 hover:bg-green-700"
                                        >

                                            Terima

                                        </a>

                                        <a
                                            href="/payment/{{ $payment->id }}/reject"
                                            class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-red-500/20 transition hover:-translate-y-0.5 hover:bg-red-700"
                                        >

                                            Tolak

                                        </a>

                                    </div>

                                @elseif($payment->status_verifikasi == 'diterima')

                                    <span class="text-green-600 font-semibold">

                                        Sudah Diverifikasi

                                    </span>

                                @else

                                    <span class="text-red-600 font-semibold">

                                        Pembayaran Ditolak

                                    </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="6"
                                class="p-8 text-center text-slate-500"
                            >

                                Data pembayaran kosong

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="border-t border-slate-100 bg-slate-50/80 px-6 py-5">

                    <div class="flex items-center justify-between">

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
                            data

                        </div>

                        <div>

                            {{ $payments->onEachSide(1)->links() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- FULLSCREEN MODAL -->
<div
    id="imageModal"
    class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50"
    onclick="closeModal()"
>

    <!-- Close -->
    <button
        class="absolute top-5 right-5 bg-red-500 hover:bg-red-600 text-white w-10 h-10 rounded-full text-xl"
    >

        ✕

    </button>

    <!-- Image -->
    <img
        id="modalImage"
        src=""
        class="max-w-full max-h-screen object-contain p-4"
    >

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/*
|--------------------------------------------------------------------------
| MODAL
|--------------------------------------------------------------------------
*/

function openModal(image)
{
    document.getElementById('imageModal')
        .classList.remove('hidden');

    document.getElementById('imageModal')
        .classList.add('flex');

    document.getElementById('modalImage')
        .src = image;
}

function closeModal()
{
    document.getElementById('imageModal')
        .classList.add('hidden');

    document.getElementById('imageModal')
        .classList.remove('flex');
}

</script>

@endsection