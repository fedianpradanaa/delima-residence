<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- PWA -->
    <meta name="theme-color" content="#0f766e">

    <meta
        name="apple-mobile-web-app-capable"
        content="yes"
    >

    <meta
        name="apple-mobile-web-app-status-bar-style"
        content="black-translucent"
    >

    <meta
        name="mobile-web-app-capable"
        content="yes"
    >

    <title>Delima Residence</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine -->
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

    <!-- Font -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        :root{
            --primary:#0f766e;
        }

        *{
            -webkit-tap-highlight-color:transparent;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            font-family:'Inter',sans-serif;
            background:#f1f5f9;
            color:#334155;
            overflow-x:hidden;
            overscroll-behavior-y:none;
            padding-bottom:env(safe-area-inset-bottom);
        }

        input,
        select,
        textarea,
        button{
            font-size:16px;
        }

        button{
            transition:all .2s ease;
        }

        button:active{
            transform:scale(.98);
        }

        .glass{
            background:rgba(255,255,255,.72);
            backdrop-filter:blur(20px);
            -webkit-backdrop-filter:blur(20px);
        }

        ::-webkit-scrollbar{
            width:6px;
            height:6px;
        }

        ::-webkit-scrollbar-thumb{
            background:#cbd5e1;
            border-radius:999px;
        }

        [x-cloak]{
            display:none !important;
        }

    </style>

</head>

<body class="antialiased">

<!-- NAVBAR -->
<nav class="glass sticky top-0 z-[999] border-b border-white/30">

    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4">

        <!-- Logo -->
        <a
            href="/"
            class="flex shrink-0 items-center gap-3 transition hover:opacity-90"
        >

            <div
                class="flex h-11 w-11 items-center justify-center rounded-2xl
                bg-gradient-to-br from-teal-500 to-teal-700
                text-lg font-bold text-white
                shadow-lg shadow-teal-500/30"
            >

                D

            </div>

            <div>

                <div class="font-bold leading-tight text-slate-800">

                    Cluster Delima Residence

                </div>

                <div class="text-xs text-slate-400">

                    Sumberjaya

                </div>

            </div>

        </a>

        @auth

        <div
            x-data="{ open:false }"
            class="ml-auto flex items-center"
        >

            <!-- Desktop Menu -->
            <div class="hidden items-center gap-2 md:flex">

                {{-- ADMIN --}}
                @if(auth()->user()->role == 'admin')

                    <a
                        href="/dashboard"
                        class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->is('dashboard')
                            ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                            : 'text-slate-600 hover:bg-slate-100'
                        }}"
                    >

                        Dashboard

                    </a>

                    <a
                        href="/payments"
                        class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->is('payments')
                            ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                            : 'text-slate-600 hover:bg-slate-100'
                        }}"
                    >

                        Pembayaran

                    </a>

                    <a
                        href="/expenses"
                        class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->is('expenses')
                            ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                            : 'text-slate-600 hover:bg-slate-100'
                        }}"
                    >

                        Pengeluaran

                    </a>

                    <a
                        href="/cash-report"
                        class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->is('cash-report')
                            ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                            : 'text-slate-600 hover:bg-slate-100'
                        }}"
                    >

                        Kas Cluster

                    </a>

                @endif

                {{-- WARGA --}}
                @if(auth()->user()->role == 'warga')

                    <a
                        href="/payment"
                        class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->is('payment')
                            ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                            : 'text-slate-600 hover:bg-slate-100'
                        }}"
                    >

                        Upload IPL

                    </a>

                    <a
                        href="/payment-history"
                        class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->is('payment-history')
                            ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                            : 'text-slate-600 hover:bg-slate-100'
                        }}"
                    >

                        Riwayat

                    </a>

                    <a
                        href="/cash-report"
                        class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                        {{ request()->is('cash-report')
                            ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                            : 'text-slate-600 hover:bg-slate-100'
                        }}"
                    >

                        Kas Cluster

                    </a>

                @endif

                <!-- Password -->
                <a
                    href="/change-password"
                    class="rounded-2xl px-4 py-2 text-sm font-medium transition-all duration-200
                    {{ request()->is('change-password')
                        ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                        : 'text-slate-600 hover:bg-slate-100'
                    }}"
                >

                    Password

                </a>

                <!-- Logout -->
                <form action="/logout" method="POST">

                    @csrf

                    <button
                        class="rounded-2xl bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition-all duration-200 hover:bg-red-100"
                    >

                        Logout

                    </button>

                </form>

            </div>

            <!-- Mobile Toggle -->
            <button
                @click="open = !open"
                class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-300 bg-white md:hidden"
            >

                ☰

            </button>

            <!-- Mobile Menu -->
            <div
                x-show="open"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="open = false"
                class="absolute right-4 top-[72px] z-[9999]
                w-72 rounded-3xl border border-white/40
                bg-white/95 p-3 shadow-2xl backdrop-blur-2xl md:hidden"
            >

                <!-- User -->
                <div class="mb-3 border-b border-slate-200 pb-3">

                    <div class="font-semibold text-slate-700">

                        {{ auth()->user()->name }}

                    </div>

                    <div class="text-xs uppercase text-slate-400">

                        {{ auth()->user()->role }}

                    </div>

                </div>

                <div class="flex flex-col gap-2">

                    {{-- ADMIN --}}
                    @if(auth()->user()->role == 'admin')

                        <a
                            href="/dashboard"
                            class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                        >

                            Dashboard

                        </a>

                        <a
                            href="/payments"
                            class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                        >

                            Pembayaran

                        </a>

                        <a
                            href="/expenses"
                            class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                        >

                            Pengeluaran

                        </a>

                        <a
                            href="/cash-report"
                            class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                        >

                            Kas Cluster

                        </a>

                    @endif

                    {{-- WARGA --}}
                    @if(auth()->user()->role == 'warga')

                        <a
                            href="/payment"
                            class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                        >

                            Upload IPL

                        </a>

                        <a
                            href="/payment-history"
                            class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                        >

                            Riwayat

                        </a>

                        <a
                            href="/cash-report"
                            class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                        >

                            Kas Cluster

                        </a>

                    @endif

                    <a
                        href="/change-password"
                        class="rounded-2xl px-4 py-3 transition hover:bg-slate-100"
                    >

                        Password

                    </a>

                    <form action="/logout" method="POST">

                        @csrf

                        <button
                            class="w-full rounded-2xl px-4 py-3 text-left text-red-600 transition hover:bg-red-50"
                        >

                            Logout

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endauth

    </div>

</nav>

<!-- CONTENT -->
<main class="pb-24 md:pb-0">

    @yield('content')

</main>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@auth

<!-- MOBILE BOTTOM NAV -->
<div
    class="fixed bottom-0 left-0 right-0 z-50 md:hidden"
    style="padding-bottom:env(safe-area-inset-bottom)"
>

    <div
        class="glass flex justify-around border-t border-white/40 px-3 py-3"
    >

        {{-- ADMIN --}}
        @if(auth()->user()->role == 'admin')

            <a
                href="/dashboard"
                class="
                flex flex-col items-center gap-1 rounded-2xl px-4 py-2 text-xs
                transition-all duration-200

                {{ request()->is('dashboard')
                    ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                    : 'text-slate-600 hover:bg-slate-100 active:scale-95'
                }}
                "
            >

                <span>🏠</span>
                <span>Home</span>

            </a>

            <a
                href="/payments"
                class="
                flex flex-col items-center gap-1 rounded-2xl px-4 py-2 text-xs
                transition-all duration-200

                {{ request()->is('payments')
                    ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                    : 'text-slate-600 hover:bg-slate-100 active:scale-95'
                }}
                "
            >

                <span>💳</span>
                <span>Bayar</span>

            </a>

            <a
                href="/cash-report"
                class="
                flex flex-col items-center gap-1 rounded-2xl px-4 py-2 text-xs
                transition-all duration-200

                {{ request()->is('cash-report')
                    ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                    : 'text-slate-600 hover:bg-slate-100 active:scale-95'
                }}
                "
            >

                <span>📊</span>
                <span>Kas</span>

            </a>

        @endif

        {{-- WARGA --}}
        @if(auth()->user()->role == 'warga')

            <a
                href="/payment"
                class="
                flex flex-col items-center gap-1 rounded-2xl px-4 py-2 text-xs
                transition-all duration-200

                {{ request()->is('payment')
                    ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                    : 'text-slate-600 hover:bg-slate-100 active:scale-95'
                }}
                "
            >

                <span>💳</span>
                <span>IPL</span>

            </a>

            <a
                href="/payment-history"
                class="
                flex flex-col items-center gap-1 rounded-2xl px-4 py-2 text-xs
                transition-all duration-200

                {{ request()->is('payment-history')
                    ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                    : 'text-slate-600 hover:bg-slate-100 active:scale-95'
                }}
                "
            >

                <span>📄</span>
                <span>Riwayat</span>

            </a>

            <a
                href="/cash-report"
                class="
                flex flex-col items-center gap-1 rounded-2xl px-4 py-2 text-xs
                transition-all duration-200

                {{ request()->is('cash-report')
                    ? 'bg-teal-600 text-white shadow-lg shadow-teal-500/30'
                    : 'text-slate-600 hover:bg-slate-100 active:scale-95'
                }}
                "
            >

                <span>📊</span>
                <span>Kas</span>

            </a>

        @endif

    </div>

</div>

@endauth

</body>
</html>