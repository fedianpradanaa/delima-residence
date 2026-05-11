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
        <div class="grid md:grid-cols-4 gap-6 mb-8">

            <!-- Total Warga -->
            <div class="bg-white rounded-3xl shadow-sm p-6">

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
            <div class="bg-white rounded-3xl shadow-sm p-6">

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
            <div class="bg-white rounded-3xl shadow-sm p-6">

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
            <div class="bg-white rounded-3xl shadow-sm p-6">

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
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-8">

            <form
                method="GET"
                action="/payments"
                class="grid md:grid-cols-4 gap-4"
            >

                <!-- Search -->
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama warga..."
                    class="rounded-2xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"
                >

                <!-- Bulan -->
                <select
                    name="bulan"
                    class="rounded-2xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"
                >

                    <option value="">
                        Semua Bulan
                    </option>

                    @for($i = 1; $i <= 12; $i++)

                        <option
                            value="{{ $i }}"
                            {{ $bulan == $i ? 'selected' : '' }}
                        >

                            Bulan {{ $i }}

                        </option>

                    @endfor

                </select>

                <!-- Tahun -->
                <select
                    name="tahun"
                    class="rounded-2xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"
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

                <!-- Button -->
                <button
                    class="bg-teal-600 hover:bg-teal-700 transition text-white rounded-2xl px-4 py-2 font-semibold"
                >

                    Filter Data

                </button>

            </form>

        </div>

        <!-- Table -->
        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <!-- Head -->
                    <thead class="bg-teal-50">

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

                        <tr class="border-b hover:bg-slate-50 transition">

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

                                <div class="flex gap-2">

                                    <a
                                        href="/payment/{{ $payment->id }}/verify"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm transition"
                                    >

                                        Terima

                                    </a>

                                    <a
                                        href="/payment/{{ $payment->id }}/reject"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm transition"
                                    >

                                        Tolak

                                    </a>

                                </div>

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