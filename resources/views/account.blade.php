@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto p-4 md:p-6">

    <!-- Header -->
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-teal-700">

            Akun Saya

        </h1>

        <p class="mt-2 text-slate-500">

            Kelola email dan password akun

        </p>

    </div>

    <!-- Profile -->
    <div class="mb-6 rounded-3xl border border-white/40 bg-gradient-to-br from-teal-500 to-teal-700 p-6 text-white shadow-xl shadow-teal-500/20">

        <div class="flex items-center justify-between flex-wrap gap-4">

            <div>

                <div class="text-xl font-bold">

                    {{ auth()->user()->name }}

                </div>

                <div class="text-teal-100">

                    Blok
                    {{ auth()->user()->resident->alamat }}

                </div>

            </div>

        </div>

    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow p-6">

        <form
            action="/account"
            method="POST"
            class="space-y-5"
        >

            @csrf

            <!-- Email -->
            <div>

                <label class="block mb-2 font-medium text-slate-700 flex items-center gap-2">

                    <!-- ICON EMAIL -->
                    <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l9 6 9-6m-18 0l9 6 9-6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

                    </svg>

                    Email

                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ auth()->user()->email }}"
                    class="w-full rounded-2xl border border-slate-300
                    px-4 py-3
                    focus:border-teal-500
                    focus:ring-1 focus:ring-teal-500"
                    required
                >

            </div>
            <!-- Password -->
            <div>

                <label class="block mb-2 font-medium text-slate-700 flex items-center gap-2">

                    <!-- ICON LOCK -->
                    <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm6 10H6a2 2 0 01-2-2v-5a2 2 0 012-2h12a2 2 0 012 2v5a2 2 0 01-2 2z" />

                    </svg>

                    Password Baru

                </label>

                <div class="relative">

                    <input
                        type="password"
                        name="password"
                        id="password"
                        minlength="6"
                        class="w-full rounded-2xl border border-slate-300
                        px-4 py-3 pr-12
                        focus:border-teal-500
                        focus:ring-1 focus:ring-teal-500"
                    >

                    <button
                        type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-teal-600"
                    >

                        <svg id="eye1" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5
                                12 5c4.477 0 8.268 2.943
                                9.542 7-1.274 4.057-5.065
                                7-9.542 7-4.477
                                0-8.268-2.943-9.542-7z" />

                        </svg>

                    </button>

                </div>

            </div>
            <!-- Konfirmasi -->
            <div>

                <label class="block mb-2 font-medium text-slate-700 flex items-center gap-2">

                    <!-- ICON CHECK -->
                    <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />

                    </svg>

                    Konfirmasi Password

                </label>

                <div class="relative">

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        minlength="6"
                        class="w-full rounded-2xl border border-slate-300
                        px-4 py-3 pr-12
                        focus:border-teal-500
                        focus:ring-1 focus:ring-teal-500"
                    >

                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation', this)"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-teal-600"
                    >

                        <svg id="eye2" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5
                                12 5c4.477 0 8.268 2.943
                                9.542 7-1.274 4.057-5.065
                                7-9.542 7-4.477
                                0-8.268-2.943-9.542-7z" />

                        </svg>

                    </button>

                </div>

            </div>

            <!-- Button -->
            <button
                class="rounded-2xl bg-teal-600
                px-5 py-3
                font-medium text-white
                transition hover:bg-teal-700"
            >

                Simpan Perubahan

            </button>

        </form>

    </div>

</div>

@if(session('success'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil',

    text: '{{ session('success') }}',

    confirmButtonColor: '#0f766e',

});

</script>

@endif


@if ($errors->any())

<script>

Swal.fire({

    icon: 'error',

    title: 'Gagal',

    html: `
        {!! implode('<br>', $errors->all()) !!}
    `,

    confirmButtonColor: '#dc2626',

});

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