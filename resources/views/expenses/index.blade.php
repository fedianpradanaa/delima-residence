@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-6">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-2xl md:text-3xl font-bold text-teal-700">

            Input Pengeluaran

        </h1>

        <p class="text-slate-500 mt-1 text-sm md:text-base">

            Kelola pengeluaran kas cluster

        </p>

    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow p-4 md:p-6 mb-8">

        <form
            action="/expenses"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-5"
        >

            @csrf

            <!-- Nama -->
            <div>

                <label class="block mb-2 font-medium text-slate-700">

                    Nama Pengeluaran

                </label>

                <input
                    type="text"
                    name="nama"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                    focus:border-teal-500 focus:ring-1 focus:ring-teal-500"
                    required
                >

            </div>

            <!-- Nominal -->
            <div>

                <label class="block mb-2 font-medium text-slate-700">

                    Nominal

                </label>

                <input
                    type="number"
                    name="nominal"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                    focus:border-teal-500 focus:ring-1 focus:ring-teal-500"
                    required
                >

            </div>

            <!-- Tanggal -->
            <div>

                <label class="block mb-2 font-medium text-slate-700">

                    Tanggal

                </label>

                <input
                    type="date"
                    name="tanggal"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                    focus:border-teal-500 focus:ring-1 focus:ring-teal-500"
                    required
                >

            </div>

            <!-- Bukti -->
            <div>

                <label class="block mb-2 font-medium text-slate-700">

                    Upload Bukti

                </label>

                <input
                    type="file"
                    name="bukti"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3"
                >

            </div>

            <!-- Keterangan -->
            <div class="md:col-span-2">

                <label class="block mb-2 font-medium text-slate-700">

                    Keterangan

                </label>

                <textarea
                    name="keterangan"
                    rows="4"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                    focus:border-teal-500 focus:ring-1 focus:ring-teal-500"
                ></textarea>

            </div>

            <!-- Button -->
            <div class="md:col-span-2">

                <button
                    class="w-full md:w-auto bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl font-medium transition"
                >

                    Simpan Pengeluaran

                </button>

            </div>

        </form>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <!-- Header -->
        <div class="p-4 md:p-5 border-b">

            <h2 class="text-lg md:text-xl font-bold text-slate-700">

                Histori Pengeluaran

            </h2>

        </div>

        <!-- Responsive -->
        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead class="bg-teal-50">

                    <tr>

                        <th class="p-4 text-left text-sm font-semibold text-slate-700">
                            Tanggal
                        </th>

                        <th class="p-4 text-left text-sm font-semibold text-slate-700">
                            Nama
                        </th>

                        <th class="p-4 text-left text-sm font-semibold text-slate-700">
                            Nominal
                        </th>

                        <th class="p-4 text-left text-sm font-semibold text-slate-700">
                            Bukti
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($expenses as $expense)

                    <tr class="border-b hover:bg-slate-50 transition">

                        <!-- Tanggal -->
                        <td class="p-4 text-sm text-slate-600 whitespace-nowrap">

                            {{ \Carbon\Carbon::parse($expense->tanggal)->format('d M Y') }}

                        </td>

                        <!-- Nama -->
                        <td class="p-4">

                            <div class="font-semibold text-slate-800">

                                {{ $expense->nama }}

                            </div>

                            @if($expense->keterangan)

                            <div class="text-sm text-slate-500 mt-1">

                                {{ $expense->keterangan }}

                            </div>

                            @endif

                        </td>

                        <!-- Nominal -->
                        <td class="p-4 font-bold text-red-600 whitespace-nowrap">

                            Rp {{ number_format($expense->nominal) }}

                        </td>

                        <!-- Bukti -->
                        <td class="p-4 whitespace-nowrap">

                            @if($expense->bukti)

                            <a
                                href="/{{ $expense->bukti }}"
                                target="_blank"
                                class="text-blue-600 hover:text-blue-700 underline"
                            >

                                Lihat Bukti

                            </a>

                            @else

                            <span class="text-slate-400">

                                -

                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="4"
                            class="p-8 text-center text-slate-500"
                        >

                            Belum ada pengeluaran

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))

<script>

document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({

        icon: 'success',

        title: 'Berhasil',

        text: '{{ session('success') }}',

        confirmButtonColor: '#0f766e',

    });

});

</script>

@endif

@endsection