@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto py-10">

    <div class="bg-white rounded-3xl shadow-xl p-8">

        <h1 class="text-3xl font-bold text-teal-700 mb-2">

            Import Data IPL

        </h1>

        <p class="text-slate-500 mb-8">

            Upload file Excel atau CSV pembayaran warga
        </p>

        @if(session('success'))

            <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">

                {{ session('success') }}

            </div>

        @endif

        <form
            action="/import-payment"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="mb-6">

                <label class="block mb-2 font-semibold">

                    File Excel / CSV
                </label>

                <input
                    type="file"
                    name="file"
                    class="w-full border rounded-2xl p-4"
                >

            </div>

            <button
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-2xl"
            >

                Import Sekarang

            </button>

        </form>

    </div>

</div>

@endsection