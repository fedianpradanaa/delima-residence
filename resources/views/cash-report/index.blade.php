@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-6">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-2xl md:text-3xl font-bold text-teal-700">

            Laporan Kas Cluster

        </h1>

        <p class="text-slate-500 mt-1">

            Monitoring pemasukan & pengeluaran kas

        </p>

    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

       @if(auth()->user()->role == 'admin')
        <!-- IPL -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-slate-500 text-sm">

                Total IPL

            </div>

            <div class="text-2xl font-bold mt-2 text-teal-700">

                Rp {{ number_format($totalIPL) }}

            </div>

        </div>
        @endif

        <!-- Kas -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-slate-500 text-sm">

                Total Kas

            </div>

            <div class="text-2xl font-bold mt-2 text-green-600">

                Rp {{ number_format($totalKas) }}

            </div>

        </div>


        @if(auth()->user()->role == 'admin')
        <!-- Denda -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-slate-500 text-sm">

                Denda RT

            </div>

            <div class="text-2xl font-bold mt-2 text-orange-500">

                Rp {{ number_format($totalDenda) }}

            </div>

        </div>
        @endif

        <!-- Pengeluaran -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-slate-500 text-sm">

                Pengeluaran Kas

            </div>

            <div class="text-2xl font-bold mt-2 text-red-600">

                Rp {{ number_format($totalPengeluaran) }}

            </div>

        </div>

        <!-- Saldo -->
        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-slate-500 text-sm">

                Saldo Kas Cluster

            </div>

            <div class="text-2xl font-bold mt-2 text-blue-600">

                Rp {{ number_format($saldoKas) }}

            </div>

        </div>

    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl shadow p-4 md:p-6 mb-8">

        <h2 class="text-lg md:text-xl font-bold text-slate-700 mb-5">

            Grafik Kas Bulanan

        </h2>

        <div class="relative w-full h-[300px]">

            <canvas id="cashChart"></canvas>

        </div>

    </div>

    @if(auth()->user()->role == 'admin')
    <!-- Table -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <!-- Pemasukan -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="p-5 border-b">

                <h2 class="font-bold text-slate-700">

                    Pemasukan Terbaru

                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[600px]">

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

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($payments as $payment)

                        <tr class="border-b">

                            <td class="p-4">

                                {{ $payment->bulan }}/{{ $payment->tahun }}

                            </td>

                            <td class="p-4">

                                Rp {{ number_format($payment->nominal_ipl) }}

                            </td>

                            <td class="p-4">

                                Rp {{ number_format($payment->nominal_kas) }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <!-- Pengeluaran -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="p-5 border-b">

                <h2 class="font-bold text-slate-700">

                    Pengeluaran Terbaru

                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[600px]">

                    <thead class="bg-red-50">

                        <tr>

                            <th class="p-4 text-left">
                                Tanggal
                            </th>

                            <th class="p-4 text-left">
                                Nama
                            </th>

                            <th class="p-4 text-left">
                                Nominal
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($expenses as $expense)

                        <tr class="border-b">

                            <td class="p-4">

                                {{ $expense->tanggal }}

                            </td>

                            <td class="p-4">

                                {{ $expense->nama }}

                            </td>

                            <td class="p-4 text-red-600 font-bold">

                                Rp {{ number_format($expense->nominal) }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    @endif

    <!-- Summary Bulanan -->
<div class="bg-white rounded-2xl shadow overflow-hidden mb-8">

    <div class="p-5 border-b">

        <h2 class="text-xl font-bold text-slate-700">

            Summary Kas Bulanan

        </h2>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full min-w-[700px]">

            <thead class="bg-teal-50">

                <tr>

                    <th class="p-4 text-left">
                        Bulan
                    </th>

                    <th class="p-4 text-left">
                        Pemasukan Kas
                    </th>

                    <th class="p-4 text-left">
                        Pengeluaran
                    </th>

                    <th class="p-4 text-left">
                        Saldo
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($monthlySummary as $item)

                <tr class="border-b hover:bg-slate-50">

                    <td class="p-4">

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

                tension: 0.4

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

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