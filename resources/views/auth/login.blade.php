@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center">

    <div class="bg-white shadow rounded-2xl p-8 w-full max-w-md">

        <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">
            Delima Residence
        </h1>

        @if(session('error'))

            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>

        @endif

        <form method="POST" action="/login">

            @csrf

            <!-- Username -->
            <div class="mb-4">

                <label class="block mb-2">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    class="w-full rounded-xl border-gray-300"
                >

            </div>

            <!-- Password -->
            <div class="mb-6">

                <label class="block mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full rounded-xl border-gray-300"
                >

            </div>

            <!-- Button -->
            <button
                class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl"
            >
                Login
            </button>

        </form>

    </div>

</div>

@endsection