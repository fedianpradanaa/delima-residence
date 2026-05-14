@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-teal-700">

            Master Warga

        </h1>

        <p class="text-slate-500 mt-1">

            Data seluruh warga cluster

        </p>

    </div>

    @if(session('success'))

        <div
            x-data="{ show:true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="mb-6 rounded-2xl border border-green-300 bg-green-100 px-5 py-4 text-green-700"
        >

            <div class="font-semibold mb-1">

                ✅ Berhasil

            </div>

            <div>

                {{ session('success') }}

            </div>

        </div>

    @endif

    @if(session('error'))

        <div
            class="mb-6 rounded-2xl border border-red-300 bg-red-100 px-5 py-4 text-red-700"
        >

            <div class="font-semibold mb-1">

                ❌ Gagal

            </div>

            <div>

                {{ session('error') }}

            </div>

        </div>

    @endif

    <div class="overflow-hidden rounded-3xl border border-white/40 bg-white/70 shadow-2xl shadow-slate-200/60 backdrop-blur-xl">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px]">

                <thead class="bg-teal-50">

                    <tr>

                        <th class="p-4 text-left">
                            Alamat
                        </th>

                        <th class="p-4 text-left">
                            Nama
                        </th>

                        <th class="p-4 text-left">
                            Status Rumah
                        </th>

                        <th class="p-4 text-left">
                            Rukem
                        </th>

                        <th class="p-4 text-left">
                            Username
                        </th>

                        <th class="p-4 text-left">
                            Email
                        </th>

                        <th class="p-4 text-left">
                            Nomor HP
                        </th>

                        <th class="p-4 text-left">
                            Tanggal Masuk
                        </th>

                        <th class="p-4 text-left">
                            Tanggal Keluar
                        </th>

                        <th class="p-4 text-left">
                            Status User
                        </th>

                        <th class="p-4 text-left">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($residents as $resident)

                    <tr class="border-b border-slate-100">

                        <td class="p-4">

                            {{ $resident->alamat }}

                        </td>

                        <td class="p-4 font-semibold">

                            {{ $resident->nama }}

                        </td>

                        <td class="p-4">

                            {{ $resident->status_rumah }}

                        </td>

                        <td class="p-4">

                            {{ $resident->rukem }}

                        </td>

                        <td class="p-4">

                            {{ $resident->user->username ?? '-' }}

                        </td>

                        <td class="p-4">

                            {{ $resident->user->email ?? '-' }}

                        </td>

                        <td class="p-4">

                            {{ $resident->nomor_hp ?? '-' }}

                        </td>

                        <td class="p-4">

                            {{ $resident->tanggal_masuk ?? '-' }}

                        </td>

                        <td class="p-4">

                            {{ $resident->tanggal_keluar ?? '-' }}

                        </td>

                        <td class="p-4">

                            @if(($resident->user->is_active ?? 0) == 1)

                                <span class="rounded-xl bg-green-100 px-3 py-1 text-sm text-green-700">

                                    Active

                                </span>

                            @else

                                <span class="rounded-xl bg-red-100 px-3 py-1 text-sm text-red-700">

                                    Non Active

                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            <a
                                href="/residents/{{ $resident->id }}/edit"
                                class="rounded-2xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white"
                            >

                                Edit

                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection