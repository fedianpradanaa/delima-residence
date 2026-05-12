@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-3xl font-bold tracking-tight text-teal-700">

            Input Pengeluaran

        </h1>

        <p class="text-slate-500 mt-1 text-sm md:text-base">

            Kelola pengeluaran kas cluster

        </p>

    </div>

    <!-- Form -->
    <div class="mb-8 rounded-[32px] border border-white/40 bg-white/70 p-5 shadow-2xl shadow-slate-200/60 backdrop-blur-xl md:p-8">

        <form
            action="/expenses"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-1 gap-5 md:grid-cols-2"
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
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-100"
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
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-100"
                    required
                >

            </div>

            <!-- Tanggal -->
            <div>

                <label class="block mb-2 font-medium text-slate-700">

                    Tanggal

                </label>

                <input
                    type="file"
                    id="bukti"
                    name="bukti"
                    accept="image/*"
                    class="hidden"
                >

                <button
                    type="button"
                    onclick="document.getElementById('bukti').click()"
                    class="w-full rounded-3xl border-2 border-dashed border-teal-200 bg-teal-50/50 p-6 text-center transition active:scale-[0.98] hover:bg-teal-50"
                >

                    <div class="mb-3 text-4xl">

                        📷

                    </div>

                    <div class="font-semibold text-slate-700">

                        Upload Bukti Pengeluaran

                    </div>

                    <div class="mt-1 text-sm text-slate-500">

                        Kamera atau gallery

                    </div>

                </button>

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
                    class="h-14 w-full rounded-2xl bg-gradient-to-r from-teal-500 to-teal-700 px-6 font-semibold text-white shadow-xl shadow-teal-500/30 transition-all md:w-auto"
                >

                    Simpan Pengeluaran

                </button>

            </div>

        </form>

    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-[32px] border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

        <!-- Header -->
        <div class="p-4 md:p-5 border-b">

            <h2 class="text-lg md:text-xl font-bold text-slate-700">

                Histori Pengeluaran

            </h2>

        </div>

        <!-- Responsive -->
        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead class="bg-teal-50/80 backdrop-blur">

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

                    <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

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
                                class="inline-flex rounded-xl bg-blue-50 px-3 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-100"
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