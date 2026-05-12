@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-3xl font-bold tracking-tight text-teal-700">

            Laporan Kas Cluster

        </h1>

        <p class="text-slate-500 mt-1">

            Monitoring pemasukan & pengeluaran kas

        </p>

    </div>

    <!-- Cards -->
    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-5">

       @if(auth()->user()->role == 'admin')
        <!-- IPL -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Total IPL

            </div>

            <div class="mt-3 text-3xl font-bold text-teal-700">

                Rp {{ number_format($totalIPL) }}

            </div>

        </div>
        @endif

        <!-- Kas -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Total Kas

            </div>

            <div class="mt-3 text-3xl font-bold text-green-600">

                Rp {{ number_format($totalKas) }}

            </div>

        </div>


        @if(auth()->user()->role == 'admin')
        <!-- Denda -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Denda RT

            </div>

            <div class="mt-3 text-3xl font-bold text-orange-500">

                Rp {{ number_format($totalDenda) }}

            </div>

        </div>
        @endif

        <!-- Pengeluaran -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Pengeluaran Kas

            </div>

            <div class="mt-3 text-3xl font-bold text-red-600">

                Rp {{ number_format($totalPengeluaran) }}

            </div>

        </div>

        <!-- Saldo -->
        <div class="rounded-3xl border border-white/40 bg-white/70 p-5 shadow-xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="text-slate-500 text-sm">

                Saldo Kas Cluster

            </div>

            <div class="mt-3 text-3xl font-bold text-blue-600">

                Rp {{ number_format($saldoKas) }}

            </div>

        </div>

    </div>

    <!-- Chart -->
    <div class="mb-8 rounded-3xl border border-white/40 bg-white/70 p-5 shadow-2xl shadow-slate-200/60 backdrop-blur-xl md:p-8">

        <h2 class="text-lg md:text-xl font-bold text-slate-700 mb-5">

            Trend Kas Bulanan

        </h2>

        <div class="relative w-full h-[220px] md:h-[300px]">

            <canvas id="cashChart"></canvas>

        </div>

    </div>

    <!-- Table -->
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        @if(auth()->user()->role == 'admin')
        <!-- Pemasukan -->
        <div class="overflow-hidden rounded-3xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="border-b border-slate-100 p-5">

                <h2 class="font-bold text-slate-700">

                    Pemasukan Terbaru

                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[600px]">

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

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($payments as $payment)

                        <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

                            <td class="p-3 md:p-4 whitespace-nowrap">

                                {{ $payment->bulan }}/{{ $payment->tahun }}

                            </td>

                            <td class="p-3 md:p-4 whitespace-nowrap">

                                Rp {{ number_format($payment->nominal_ipl) }}

                            </td>

                            <td class="p-3 md:p-4 whitespace-nowrap">

                                Rp {{ number_format($payment->nominal_kas) }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>
        @endif

        <!-- Pengeluaran -->
        <div class="overflow-hidden rounded-3xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

            <div class="border-b border-slate-100 p-5">

                <h2 class="font-bold text-slate-700">

                    Pengeluaran Terbaru

                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[500px] md:min-w-[600px] text-sm md:text-base">

                    <thead class="bg-red-50/80 backdrop-blur">

                        <tr>

                            <th class="p-3 md:p-4 text-left whitespace-nowrap">
                                Tanggal
                            </th>

                            <th class="p-3 md:p-4 text-left whitespace-nowrap">
                                Nama
                            </th>

                            <th class="p-3 md:p-4 text-left whitespace-nowrap">
                                Nominal
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($expenses as $expense)

                        <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

                            <td class="p-3 md:p-4 whitespace-nowrap">

                                {{ $expense->tanggal }}

                            </td>

                            <td class="p-3 md:p-4">

                                {{ $expense->nama }}

                            </td>

                            <td class="p-3 md:p-4 text-red-600 font-bold whitespace-nowrap">

                                Rp {{ number_format($expense->nominal) }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

<!-- Summary Bulanan -->
<div class="mt-6 mb-8 overflow-hidden rounded-3xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

    <div class="border-b border-slate-100 p-5">

        <h2 class="font-bold text-slate-700">

            Summary Kas Bulanan

        </h2>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full min-w-[700px] text-sm md:text-base">

            <thead class="bg-teal-50/80 backdrop-blur">

                <tr>

                    <th class="p-3 md:p-4 text-left whitespace-nowrap">
                        Bulan
                    </th>

                    <th class="p-3 md:p-4 text-left whitespace-nowrap">
                        Pemasukan Kas
                    </th>

                    <th class="p-3 md:p-4 text-left whitespace-nowrap">
                        Pengeluaran
                    </th>

                    <th class="p-3 md:p-4 text-left whitespace-nowrap">
                        Saldo
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($monthlySummary as $item)

                <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

                    <td class="p-3 md:p-4 whitespace-nowrap">

                        {{ \Carbon\Carbon::create()
                            ->month($item['bulan'])
                            ->translatedFormat('F') }}

                        {{ $item['tahun'] }}

                    </td>

                    <td class="p-4 text-green-600 font-semibold">

                        Rp {{ number_format($item['pemasukan']) }}

                    </td>

                    <td class="p-4 text-red-600 font-semibold">

                        Rp {{ number_format($item['pengeluaran']) }}

                    </td>

                    <td class="p-4 text-blue-600 font-bold">

                        Rp {{ number_format($item['saldo']) }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const chartData = @json($chartData);

const labels = chartData.map(item => item.bulan_angka);

const kas = chartData.map(item => item.kas);

new Chart(
    document.getElementById('cashChart'),
    {
        type: 'line',

        data: {

            labels: labels,

            datasets: [{

            label: 'Kas',

            data: kas,

            tension: 0.4,

            fill: true,

            borderWidth: 3,

            pointRadius: 4,

            pointHoverRadius: 6,

            backgroundColor: 'rgba(20,184,166,0.12)',

            borderColor: '#0f766e'

        }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                mode: 'index',

                intersect: false

            },

            plugins: {

                legend: {

                    display: false

                }

            },

            scales: {

                x: {

                    grid: {

                        display: false

                    },

                    ticks: {

                        color: '#64748b'

                    }

                },

                y: {

                    beginAtZero: true,

                    grid: {

                        color: 'rgba(148,163,184,0.08)'

                    },

                    ticks: {

                        color: '#64748b',

                        stepSize: 100000,

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

</script>

@endsection