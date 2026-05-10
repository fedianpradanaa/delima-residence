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
    <nav class="bg-teal-600 shadow">

        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

            <h1 class="text-white text-xl font-bold">
                Delima Residence
            </h1>

            @auth

            <div class="flex items-center gap-4">

                {{-- ADMIN --}}
                @if(auth()->user()->role == 'admin')

                    <a
                        href="/dashboard"
                        class="text-white"
                    >
                        Dashboard
                    </a>

                    <a
                        href="/payments"
                        class="text-white"
                    >
                        Pembayaran
                    </a>

                @endif

                {{-- WARGA --}}
                @if(auth()->user()->role == 'warga')

                    <a
                        href="/payment/create"
                        class="text-white"
                    >
                        Pembayaran
                    </a>

                    <a
                        href="/payment/history"
                        class="text-white"
                    >
                        Riwayat
                    </a>

                @endif

                {{-- SEMUA USER --}}
                <a
                    href="/change-password"
                    class="text-white"
                >
                    Ganti Password
                </a>

                <form action="/logout" method="POST">

                    @csrf

                    <button class="text-white">
                        Logout
                    </button>

                </form>

            </div>

            @endauth

        </div>

    </nav>

    <!-- Content -->
    @yield('content')

</body>
</html>