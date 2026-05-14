@extends('layouts.app')

@section('content')

<div
    class="min-h-screen
    bg-gradient-to-br from-slate-100 via-white to-slate-200
    flex justify-center
    px-4 pt-10 pb-6 sm:py-10"
>

    <div class="w-full max-w-sm">

        <!-- Logo -->
        <div class="text-center mb-6 sm:mb-8">

            <div class="relative mx-auto mb-4 w-24 h-24 sm:w-28 sm:h-28">

                <div class="absolute inset-0 bg-teal-500/20 blur-xl sm:blur-2xl rounded-full"></div>

                <div
                    class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-[30px]
                    bg-gradient-to-br from-teal-500 to-teal-700
                    flex items-center justify-center
                    text-white text-5xl sm:text-6xl font-bold leading-none
                    shadow-2xl shadow-teal-500/30"
                >
                    D
                </div>

            </div>

            <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 tracking-tight">

                Delima Residence

            </h1>

            <p class="text-slate-500 text-sm sm:text-base mt-2 leading-relaxed">

                Pembayaran IPL Cluster<br>
                & Laporan Keuangan

            </p>

        </div>

        <!-- Card -->
        <div
            class="glass border border-white/40
            rounded-[32px]
            shadow-2xl shadow-slate-200/60
            p-4 sm:p-6"
        >

            @if($errors->any())

                <div
                    class="mb-4 rounded-2xl
                    border border-red-200
                    bg-red-50
                    px-4 py-3
                    text-sm font-medium text-red-700"
                >

                    {{ $errors->first() }}

                </div>

            @endif

            <form method="POST" action="/login" class="space-y-4 sm:space-y-5">

                @csrf

                <!-- Username -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">

                        <!-- ICON USER -->
                        <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <!-- simple person -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-4 0-7 2-7 5v1h14v-1c0-3-3-5-7-5z" />

                        </svg>

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        autocomplete="username"
                        required
                        placeholder="Masukkan username"
                        class="w-full h-12 sm:h-14 rounded-2xl
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

                    <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">

                        <!-- ICON LOCK -->
                        <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <!-- lock / gembok -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c1.657 0 3-1.343 3-3V7a3 3 0 10-6 0v1c0 1.657 1.343 3 3 3zm6 1H6a2 2 0 00-2 2v5a2 2 0 002 2h12a2 2 0 002-2v-5a2 2 0 00-2-2z" />

                        </svg>

                        Password

                    </label>

                    <div class="relative">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            required
                            placeholder="Masukkan password"
                            class="w-full h-12 sm:h-14 rounded-2xl
                            border border-slate-200
                            bg-slate-50
                            px-4 pr-12
                            focus:outline-none
                            focus:ring-4
                            focus:ring-teal-100
                            focus:border-teal-500"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password', this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-teal-600 transition"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5
                                    12 5c4.477 0 8.268 2.943
                                    9.542 7-1.274 4.057-5.065
                                    7-9.542 7-4.477
                                    0-8.268-2.943-9.542-7z"
                                />

                            </svg>

                        </button>

                    </div>

                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full h-12 sm:h-14 rounded-2xl
                    bg-gradient-to-r from-teal-500 to-teal-700
                    text-white font-semibold
                    shadow-lg shadow-teal-500/30"
                >

                    Login

                </button>

            </form>

        </div>

        <!-- Footer -->
        <div class="text-center mt-4 sm:mt-6">

            <p class="text-[11px] sm:text-xs text-slate-400">

                © {{ date('Y') }} Delima Residence

            </p>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('login_error'))

<script>

window.onload = function () {

    Swal.fire({

        icon: 'error',

        title: 'Login Gagal',

        text: '{{ session('login_error') }}',

        confirmButtonColor: '#0f766e',

    });

}

</script>

@endif

<script>

function togglePassword(fieldId, button)
{
    const field = document.getElementById(fieldId);

    const icon = button.querySelector('svg');

    if (field.type === 'password') {

        field.type = 'text';

        icon.classList.add('text-teal-600');

    } else {

        field.type = 'password';

        icon.classList.remove('text-teal-600');

    }
}

</script>

@endsection