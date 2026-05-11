<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Delima Residence</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS -->
    <script defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>

    <!-- Font -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        body {
            font-family: 'Inter', sans-serif;
        }

    </style>

</head>

<body class="bg-slate-50">

<!-- Navbar -->
<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4">

        <div class="h-16 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-2xl bg-teal-600 flex items-center justify-center text-white font-bold shadow">

                    D

                </div>

                <div>

                    <div class="font-bold text-slate-800">

                        Cluster Delima Residence

                    </div>

                    <div class="text-xs text-slate-400">

                        Sumberjaya

                    </div>

                </div>

            </div>

            @auth

            <div
                x-data="{ open:false }"
                class="flex items-center"
            >

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-2">

                    {{-- ADMIN --}}
                    @if(auth()->user()->role == 'admin')

                        <a
                            href="/dashboard"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition
                            {{ request()->is('dashboard') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                        >

                            Dashboard

                        </a>

                        <a
                            href="/payments"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition
                            {{ request()->is('payments') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                        >

                            Pembayaran

                        </a>

                        <a
                            href="/expenses"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition
                            {{ request()->is('expenses') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                        >

                            Pengeluaran

                        </a>

                        <a
                            href="/cash-report"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition
                            {{ request()->is('cash-report') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                        >

                            Kas Cluster

                        </a>

                    @endif

                    {{-- WARGA --}}
                    @if(auth()->user()->role == 'warga')

                        <a
                            href="/payment"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition
                            {{ request()->is('payment') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                        >

                            Upload IPL

                        </a>

                        <a
                            href="/payment-history"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition
                            {{ request()->is('payment-history') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                        >

                            Riwayat

                        </a>

                        <a
                            href="/cash-report"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition
                            {{ request()->is('cash-report') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                        >

                            Kas Cluster

                        </a>

                    @endif

                    {{-- PASSWORD --}}
                    <a
                        href="/change-password"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition
                        {{ request()->is('change-password') ? 'bg-teal-600 text-white shadow' : 'text-slate-600 hover:bg-slate-100' }}"
                    >

                        Password

                    </a>

                    <!-- Logout -->
                    <form action="/logout" method="POST">

                        @csrf

                        <button
                            class="bg-red-50 hover:bg-red-100 text-red-600
                            px-4 py-2 rounded-xl text-sm font-medium transition"
                        >

                            Logout

                        </button>

                    </form>

                </div>

                <!-- Mobile Button -->
                <button
                    @click="open = !open"
                    class="md:hidden w-11 h-11 rounded-xl border border-slate-300
                    flex items-center justify-center"
                >

                    ☰

                </button>

                <!-- Mobile Menu -->
                <div
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    class="absolute top-16 right-4 w-64 bg-white border border-slate-200
                    rounded-2xl shadow-xl p-3 md:hidden z-50"
                >

                    <div class="mb-3 pb-3 border-b border-slate-200">

                        <div class="font-semibold text-slate-700">

                            {{ auth()->user()->name }}

                        </div>

                        <div class="text-xs text-slate-400 uppercase">

                            {{ auth()->user()->role }}

                        </div>

                    </div>

                    <div class="flex flex-col gap-2">

                        {{-- ADMIN --}}
                        @if(auth()->user()->role == 'admin')

                            <a href="/dashboard" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                                Dashboard
                            </a>

                            <a href="/payments" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                                Pembayaran
                            </a>

                            <a href="/expenses" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                                Pengeluaran
                            </a>

                            <a href="/cash-report" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                                Kas Cluster
                            </a>

                        @endif

                        {{-- WARGA --}}
                        @if(auth()->user()->role == 'warga')

                            <a href="/payment" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                                Upload IPL
                            </a>

                            <a href="/payment-history" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                                Riwayat
                            </a>

                            <a href="/cash-report" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                                Kas Cluster
                            </a>

                        @endif

                        <a href="/change-password" class="px-4 py-3 rounded-xl hover:bg-slate-100">
                            Password
                        </a>

                        <form action="/logout" method="POST">

                            @csrf

                            <button
                                class="w-full text-left px-4 py-3 rounded-xl
                                text-red-600 hover:bg-red-50"
                            >

                                Logout

                            </button>

                        </form>

                    </div>

                </div>

            </div>

            @endauth

        </div>

    </div>

</nav>

    <!-- Content -->
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>