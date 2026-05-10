@extends('layouts.app')

@section('content')

<div class="p-6 bg-slate-100 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>

            <h1 class="text-3xl font-bold text-teal-700">

                Dashboard Admin

            </h1>

            <p class="text-slate-500 mt-1">

                Monitoring pembayaran Delima Residence

            </p>

        </div>

        <!-- Filter -->
        <form
            method="GET"
            action="/dashboard"
            class="flex flex-col md:flex-row gap-3"
        >

            <select
                name="bulan"
                class="rounded-xl border-slate-300"
            >

                @for($i = 1; $i <= 12; $i++)

                    <option
                        value="{{ $i }}"
                        {{ request('bulan') == $i ? 'selected' : '' }}
                    >

                        Bulan {{ $i }}

                    </option>

                @endfor

            </select>

            <select
                name="tahun"
                class="rounded-xl border-slate-300"
            >

                @for($i = 2025; $i <= 2035; $i++)

                    <option
                        value="{{ $i }}"
                        {{ request('tahun') == $i ? 'selected' : '' }}
                    >

                        {{ $i }}

                    </option>

                @endfor

            </select>

            <button
                class="bg-teal-600 hover:bg-teal-700 text-white px-5 rounded-xl"
            >

                Filter

            </button>

        </form>

    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

        <!-- Total Warga -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-teal-600 text-3xl mb-3">

                🏠

            </div>

            <div class="text-slate-500 text-sm">

                Total Warga

            </div>

            <div class="text-3xl font-bold mt-2">

                {{ $totalWarga }}

            </div>

        </div>

        <!-- Rumah Kosong -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-red-500 text-3xl mb-3">

                🚫

            </div>

            <div class="text-slate-500 text-sm">

                Rumah Kosong

            </div>

            <div class="text-3xl font-bold mt-2">

                {{ $rumahKosong }}

            </div>

        </div>

        <!-- Belum Bayar -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-yellow-500 text-3xl mb-3">

                ⏳

            </div>

            <div class="text-slate-500 text-sm">

                Belum Bayar

            </div>

            <div class="text-3xl font-bold mt-2">

                {{ $belumBayar }}

            </div>

        </div>

        <!-- Tidak Ronda -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-orange-500 text-3xl mb-3">

                🌙

            </div>

            <div class="text-slate-500 text-sm">

                Tidak Ronda

            </div>

            <div class="text-3xl font-bold mt-2">

                {{ $tidakRonda }}

            </div>

        </div>

        <!-- Total Pemasukan -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-green-600 text-3xl mb-3">

                💰

            </div>

            <div class="text-slate-500 text-sm">

                Total Pemasukan

            </div>

            <div class="text-2xl font-bold mt-2 text-teal-700">

                Rp {{ number_format($totalPemasukan) }}

            </div>

        </div>

    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl shadow p-6 mb-8">

        <div class="flex justify-between items-center mb-5">

            <h2 class="text-xl font-bold text-slate-700">

                Grafik Pembayaran

            </h2>

        </div>

        <canvas id="paymentChart"></canvas>

    </div>

    <!-- Payment Realtime -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-5 border-b">

            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">

                <h2 class="text-xl font-bold text-slate-700">

                    Pembayaran Realtime Warga

                </h2>

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari warga..."
                    class="rounded-xl border-slate-300 w-full md:w-72"
                >

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full" id="paymentTable">

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

                    </tr>

                </thead>

                <tbody>

                    @forelse($payments as $payment)

                    <tr class="border-b hover:bg-slate-50">

                        <!-- Nama -->
                        <td class="p-4">

                            <div class="font-semibold">

                                {{ $payment->user->name }}

                            </div>

                            <div class="text-sm text-slate-500">

                                {{ $payment->user->username }}

                            </div>

                        </td>

                        <!-- Bulan -->
                        <td class="p-4">

                            {{ $payment->bulan }}/{{ $payment->tahun }}

                        </td>

                        <!-- Total -->
                        <td class="p-4 font-bold text-teal-700">

                            Rp {{ number_format($payment->total) }}

                        </td>

                        <!-- Status -->
                        <td class="p-4">

                            @if($payment->status_verifikasi == 'diterima')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                    Diterima

                                </span>

                            @elseif($payment->status_verifikasi == 'ditolak')

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                                    Ditolak

                                </span>

                            @else

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">

                                    Pending

                                </span>

                            @endif

                        </td>

                        <!-- Bukti -->
                        <td class="p-4">

                            <button
                                onclick="openModal('/{{ $payment->bukti_bayar }}')"
                                class="text-blue-600 underline"
                            >

                                Preview

                            </button>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="5"
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

<!-- Modal -->
<div
    id="imageModal"
    class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50"
>

    <div class="relative max-w-5xl w-full p-4">

        <button
            onclick="closeModal()"
            class="absolute top-5 right-5 bg-red-500 text-white w-10 h-10 rounded-full"
        >

            ✕

        </button>

        <img
            id="modalImage"
            src=""
            class="w-full max-h-[90vh] object-contain rounded-2xl"
        >

    </div>

</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const chartData = @json($chartData);

const labels = chartData.map(item => item.bulan_angka);

const totals = chartData.map(item => item.total);

new Chart(
    document.getElementById('paymentChart'),
    {
        type: 'line',

        data: {

            labels: labels,

            datasets: [{

                label: 'Pembayaran',

                data: totals,

                tension: 0.4

            }]
        },

        options: {

            responsive: true,

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        stepSize: 500000,

                        callback: function(value) {

                            return 'Rp ' +
                                value.toLocaleString('id-ID');

                        }

                    }

                }

            }

        }
    }
);

/*
|--------------------------------------------------------------------------
| SEARCH REALTIME
|--------------------------------------------------------------------------
*/

document
    .getElementById('searchInput')
    .addEventListener('keyup', function () {

        let value =
            this.value.toLowerCase();

        let rows =
            document.querySelectorAll(
                '#paymentTable tbody tr'
            );

        rows.forEach((row) => {

            row.style.display =
                row.innerText
                    .toLowerCase()
                    .includes(value)
                    ? ''
                    : 'none';

        });

});

/*
|--------------------------------------------------------------------------
| MODAL
|--------------------------------------------------------------------------
*/

function openModal(image)
{
    document
        .getElementById('imageModal')
        .classList.remove('hidden');

    document
        .getElementById('imageModal')
        .classList.add('flex');

    document
        .getElementById('modalImage')
        .src = image;
}

function closeModal()
{
    document
        .getElementById('imageModal')
        .classList.add('hidden');

    document
        .getElementById('imageModal')
        .classList.remove('flex');
}

</script>

@endsection