@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto py-10 px-4">

    <div class="bg-white rounded-2xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6 text-teal-700">
            Ganti Password
        </h1>

        <!-- Error -->
        @if(session('error'))

            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                {{ session('error') }}
            </div>

        @endif

        <!-- Success -->
        @if(session('success'))

            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>

        @endif

        <form method="POST" action="/change-password">

            @csrf

            <!-- Password Lama -->
            <div class="mb-4">

                <label class="block mb-2">
                    Password Lama
                </label>

                <input
                    type="password"
                    name="password_lama"
                    class="w-full rounded-xl border-gray-300"
                >

            </div>

            <!-- Password Baru -->
            <div class="mb-4">

                <label class="block mb-2">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password_baru"
                    class="w-full rounded-xl border-gray-300"
                >

            </div>

            <!-- Konfirmasi -->
            <div class="mb-6">

                <label class="block mb-2">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    name="konfirmasi_password"
                    class="w-full rounded-xl border-gray-300"
                >

            </div>

            <button
                class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-3 rounded-xl"
            >
                Simpan Password
            </button>

        </form>

    </div>

</div>

@endsection