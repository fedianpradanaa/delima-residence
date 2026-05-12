@extends('layouts.app')

@section('content')

<div
    class="min-h-screen
    bg-gradient-to-br from-slate-100 via-white to-slate-200
    flex items-center justify-center
    px-4 py-10"
>

    <div class="w-full max-w-sm">

        <!-- Logo -->
        <div class="text-center mb-8">

            <div class="relative mx-auto mb-5 w-24 h-24">

                <div class="absolute inset-0 bg-teal-500/20 blur-2xl rounded-full"></div>

                <div
                    class="relative w-24 h-24 rounded-[28px]
                    bg-gradient-to-br from-teal-500 to-teal-700
                    flex items-center justify-center
                    text-white text-5xl font-bold
                    shadow-2xl shadow-teal-500/30"
                >
                    D
                </div>

            </div>

            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">

                Delima Residence

            </h1>

            <p class="text-slate-500 text-sm mt-2 leading-relaxed">

                Pembayaran IPL Cluster<br>
                & Laporan Keuangan

            </p>

        </div>

        <!-- Card -->
        <div
            class="glass border border-white/40
            rounded-[32px]
            shadow-2xl shadow-slate-200/60
            p-6"
        >

            @if(session('error'))

                <div
                    class="mb-5 rounded-2xl
                    border border-red-200
                    bg-red-50
                    px-4 py-3
                    text-sm text-red-700"
                >
                    {{ session('error') }}
                </div>

            @endif

            <form method="POST" action="/login" class="space-y-5">

                @csrf

                <!-- Username -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        autocomplete="username"
                        required
                        placeholder="Masukkan username"
                        class="w-full h-14 rounded-2xl
                        border border-slate-200
                        bg-slate-50
                        px-4
                        focus:outline-none
                        focus:ring-4
                        focus:ring-teal-100
                        focus:border-teal-500"
                    >

                </div>

                <!-- Password -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        required
                        placeholder="Masukkan password"
                        class="w-full h-14 rounded-2xl
                        border border-slate-200
                        bg-slate-50
                        px-4
                        focus:outline-none
                        focus:ring-4
                        focus:ring-teal-100
                        focus:border-teal-500"
                    >

                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full h-14 rounded-2xl
                    bg-gradient-to-r from-teal-500 to-teal-700
                    text-white font-semibold
                    shadow-lg shadow-teal-500/30"
                >

                    Login

                </button>

            </form>

        </div>

        <!-- Footer -->
        <div class="text-center mt-6">

            <p class="text-xs text-slate-400">

                © {{ date('Y') }} Delima Residence

            </p>

        </div>

    </div>

</div>

@endsection