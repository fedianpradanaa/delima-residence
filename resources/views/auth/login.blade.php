@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 py-10 bg-slate-100">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">

            <div class="w-20 h-20 bg-teal-600 rounded-3xl mx-auto
                        flex items-center justify-center
                        text-white text-4xl font-bold shadow-lg mb-5">

                D

            </div>

            <h1 class="text-3xl font-bold text-slate-800">

                Delima Residence

            </h1>

            <p class="text-slate-500 mt-2">

                Sistem Pembayaran IPL Cluster

            </p>

        </div>

        <!-- Card -->
        <div class="bg-white border border-slate-200 shadow rounded-2xl p-6 md:p-8">

            <!-- Error -->
            @if(session('error'))

                <div
                    class="bg-red-50 border border-red-200
                    text-red-700 px-4 py-3 rounded-xl mb-6"
                >

                    {{ session('error') }}

                </div>

            @endif

            <!-- Form -->
            <form
                method="POST"
                action="/login"
                class="space-y-5"
            >

                @csrf

                <!-- Username -->
                <div>

                    <label class="block text-sm font-semibold mb-2 text-slate-700">

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        autocomplete="username"
                        required
                        class="w-full rounded-lg border border-slate-300
                        bg-white px-4 py-3
                        focus:border-teal-500
                        focus:ring-1
                        focus:ring-teal-500"
                    >

                </div>

                <!-- Password -->
                <div>

                    <label class="block text-sm font-semibold mb-2 text-slate-700">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-lg border border-slate-300
                        bg-white px-4 py-3
                        focus:border-teal-500
                        focus:ring-1
                        focus:ring-teal-500"
                    >

                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full bg-teal-600 hover:bg-teal-700
                    text-white py-3 rounded-lg
                    font-semibold transition shadow"
                >

                    Login

                </button>

            </form>

        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-slate-400 mt-6">

            © {{ date('Y') }} Delima Residence

        </div>

    </div>

</div>

@endsection