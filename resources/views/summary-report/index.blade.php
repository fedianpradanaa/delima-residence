@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-3xl font-bold tracking-tight text-teal-700">

            Summary Laporan RT

        </h1>

        <p class="text-slate-500 mt-1">

            Rekap pembayaran warga & laporan keuangan cluster

        </p>

    </div>

    <!-- Filter -->
    <div class="mb-8 rounded-3xl border border-white/40 bg-white/70 p-5 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

        <form class="grid grid-cols-1 gap-4 md:grid-cols-4">

            <!-- Bulan -->
            <div>

                <label class="block mb-2 text-sm font-medium text-slate-600">

                    Bulan

                </label>

                <select
                    name="bulan"
                    class="w-full rounded-2xl border-slate-200 bg-white/80"
                >

                    <option value="">
                        Semua Bulan
                    </option>

                    @for($i = 1; $i <= 12; $i++)

                        <option
                            value="{{ $i }}"
                            {{ request('bulan') == $i ? 'selected' : '' }}
                        >

                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

                        </option>

                    @endfor

                </select>

            </div>

            <!-- Tahun -->
            <div>

                <label class="block mb-2 text-sm font-medium text-slate-600">

                    Tahun

                </label>

                <select
                    name="tahun"
                    class="w-full rounded-2xl border-slate-200 bg-white/80"
                >

                    <option value="">
                        Semua Tahun
                    </option>

                    @for($tahunLoop = 2025; $tahunLoop <= 2030; $tahunLoop++)

                        <option
                            value="{{ $tahunLoop }}"
                            {{ request('tahun') == $tahunLoop ? 'selected' : '' }}
                        >

                            {{ $tahunLoop }}

                        </option>

                    @endfor

                </select>

            </div>

            <!-- Button -->
            <div class="md:col-span-2 flex items-end">

                <button
                    class="w-full md:w-auto rounded-2xl bg-teal-600 px-6 py-3 font-semibold text-white shadow-lg shadow-teal-600/20 transition hover:bg-teal-700"
                >

                    Filter Laporan

                </button>

            </div>

        </form>

    </div>

    <!-- Cards -->
    <div class="mb-8 grid grid-cols-2 gap-5 xl:grid-cols-6">

        <!-- Warga -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Warga Bayar

            </div>

            <div class="mt-3 text-3xl font-bold text-teal-700">

                {{ $totalWargaBayar }}

            </div>

        </div>

        <!-- IPL -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Total IPL

            </div>

            <div class="mt-3 text-2xl font-bold text-blue-600">

                Rp {{ number_format($totalIPL) }}

            </div>

        </div>

        <!-- Kas -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Total Kas

            </div>

            <div class="mt-3 text-2xl font-bold text-green-600">

                Rp {{ number_format($totalKas) }}

            </div>

        </div>

        <!-- Denda -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Total Denda

            </div>

            <div class="mt-3 text-2xl font-bold text-orange-500">

                Rp {{ number_format($totalDenda) }}

            </div>

        </div>

        <!-- Pengeluaran -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Pengeluaran

            </div>

            <div class="mt-3 text-2xl font-bold text-red-600">

                Rp {{ number_format($totalPengeluaran) }}

            </div>

        </div>

        <!-- Saldo -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Saldo

            </div>

            <div class="mt-3 text-2xl font-bold text-teal-700">

                Rp {{ number_format($saldo) }}

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-3xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

        <div class="border-b border-slate-100 p-5">

            <h2 class="font-bold text-slate-700">

                Summary Pembayaran Warga

            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[950px] text-sm md:text-base">

                <thead class="bg-teal-50/80 backdrop-blur">

                    <tr>

                        <th class="p-4 text-left whitespace-nowrap">
                            Periode
                        </th>

                        <th class="p-4 text-left whitespace-nowrap">
                            Warga Bayar
                        </th>

                        <th class="p-4 text-left whitespace-nowrap">
                            IPL
                        </th>

                        <th class="p-4 text-left whitespace-nowrap">
                            Kas
                        </th>

                        <th class="p-4 text-left whitespace-nowrap">
                            Denda
                        </th>

                        <th class="p-4 text-left whitespace-nowrap">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($summaryPerBulan as $item)

                    <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

                        <td class="p-4 whitespace-nowrap font-semibold">

                            {{ $item['periode'] }}

                        </td>

                        <td class="p-4 whitespace-nowrap">

                            {{ $item['warga'] }} warga

                        </td>

                        <td class="p-4 whitespace-nowrap text-blue-600 font-semibold">

                            Rp {{ number_format($item['ipl']) }}

                        </td>

                        <td class="p-4 whitespace-nowrap text-green-600 font-semibold">

                            Rp {{ number_format($item['kas']) }}

                        </td>

                        <td class="p-4 whitespace-nowrap text-orange-500 font-semibold">

                            Rp {{ number_format($item['denda']) }}

                        </td>

                        <td class="p-4 whitespace-nowrap text-teal-700 font-bold">

                            Rp {{ number_format($item['total']) }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- Laporan RT -->
<div class="mt-6 overflow-hidden rounded-3xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

    <div class="border-b border-slate-100 p-5">

        <h2 class="font-bold text-slate-700">

            Laporan RT

        </h2>

        <p class="text-sm text-slate-400 mt-1">

            Perhitungan khusus setoran RT

        </p>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full min-w-[800px] text-sm md:text-base">

            <thead class="bg-slate-100/80">

                <tr>

                    <th class="p-4 text-left whitespace-nowrap">
                        Periode
                    </th>

                    <th class="p-4 text-left whitespace-nowrap">
                        Total Warga
                    </th>

                    <th class="p-4 text-left whitespace-nowrap">
                        Denda Ronda
                    </th>

                    <th class="p-4 text-left whitespace-nowrap">
                        IPL
                    </th>

                    <th class="p-4 text-left whitespace-nowrap">
                        Total
                    </th>

                </tr>

            </thead>

            <tbody>

                <tbody>

                @foreach($laporanRT as $item)

                <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition">

                    <td class="p-4 whitespace-nowrap font-semibold">

                        {{ $item['periode'] }}

                    </td>

                    <td class="p-4 whitespace-nowrap">

                        {{ $item['warga'] }} Warga

                    </td>

                    <td class="p-4 whitespace-nowrap text-orange-500 font-semibold">

                        Rp {{ number_format($item['denda']) }}

                    </td>

                    <td class="p-4 whitespace-nowrap text-blue-600 font-bold">

                        Rp {{ number_format($item['total_rt']) }}

                    </td>

                    <td class="p-4 whitespace-nowrap text-green-600 font-bold">

                        Rp {{ number_format(
                            $item['total_rt'] + $item['denda']
                        ) }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<!-- Belum Bayar IPL -->
<div class="mt-6 overflow-hidden rounded-3xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

    <div class="border-b border-slate-100 p-5">

        <h2 class="font-bold text-slate-700">

            Warga Belum Bayar IPL

        </h2>

        <p class="text-sm text-slate-400 mt-1">

            Daftar warga yang belum melakukan pembayaran

        </p>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full min-w-[800px] text-sm md:text-base">

            <thead class="bg-red-50/80">

                <tr>

                    <th class="p-4 text-left whitespace-nowrap">
                        Alamat
                    </th>

                    <th class="p-4 text-left whitespace-nowrap">
                        Nama
                    </th>

                    <th class="p-4 text-left whitespace-nowrap">
                        Periode
                    </th>

                    <th class="p-4 text-left whitespace-nowrap">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($belumBayar as $item)

                    <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition">

                        <td class="p-4 font-semibold">

                            {{ $item['alamat'] }}

                        </td>

                        <td class="p-4">

                            {{ $item['nama'] }}

                        </td>

                        <td class="p-4 whitespace-nowrap font-semibold text-orange-600">

                            {{ $item['periode'] }}

                        </td>

                        <td class="p-4">

                            <span class="rounded-xl bg-red-100 px-3 py-1 text-sm text-red-700">

                                {{ $item['status'] }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="p-6 text-center text-slate-400"
                        >

                            Semua warga sudah bayar 🎉

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection