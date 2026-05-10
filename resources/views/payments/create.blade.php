@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-4">

    <div class="bg-white rounded-3xl shadow-xl p-8">

        <!-- Header -->
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-teal-700 mb-2">

                Upload Pembayaran

            </h1>

            <p class="text-slate-500">

                Pembayaran IPL Delima Residence

            </p>

            <!-- Welcome Card -->
            <div class="bg-teal-50 border border-teal-200 rounded-3xl p-5 mb-8">

                <div class="text-sm text-slate-500 mb-1">
                    Selamat Datang
                </div>

                <div class="text-2xl font-bold text-teal-700 mb-3">

                    {{ auth()->user()->name }}

                </div>

                <div class="grid md:grid-cols-2 gap-4 text-sm">

                    <div>

                        <div class="text-slate-500">
                            Rumah
                        </div>

                        <div class="font-semibold">

                            {{ auth()->user()->resident->alamat ?? '-' }}

                        </div>

                    </div>

                    <div>

                        <div class="text-slate-500">
                            Username
                        </div>

                        <div class="font-semibold">

                            {{ auth()->user()->username }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Success -->
        @if(session('success'))

            <div
                class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl mb-6"
            >

                <div class="font-semibold mb-1">

                    ✅ Berhasil

                </div>

                <div>

                    {{ session('success') }}

                </div>

            </div>

        @endif

        <!-- Error -->
        @if(session('error'))

            <div
                class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl mb-6"
            >

                <div class="font-semibold mb-1">

                    ❌ Gagal

                </div>

                <div>

                    {{ session('error') }}

                </div>

            </div>

        @endif

        <!-- Validation Error -->
        @if ($errors->any())

            <div
                class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl mb-6"
            >

                <div class="font-semibold mb-2">

                    Validation Error

                </div>

                <ul class="list-disc ml-5 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FORM -->
        <form
            action="/payment"
            method="POST"
            enctype="multipart/form-data"
            x-data="paymentForm()"
        >

            @csrf

            <!-- Periode -->
            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Periode Pembayaran

                </label>

                <select
                    name="periode"
                    x-model="periode"
                    class="w-full rounded-2xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"
                    required
                >

                    <option value="">

                        Pilih Periode

                    </option>

                    @foreach($availablePeriods as $item)

                        <option
                            value="{{ $item['bulan'] }}|{{ $item['tahun'] }}"
                        >

                            {{ $item['label'] }}

                        </option>

                    @endforeach

                </select>

            </div>

            <!-- Status Ronda -->
            <div class="mb-5">

                <label class="block font-semibold mb-3">

                    Status Ronda

                </label>

                <label class="flex items-center gap-3 mb-3">

                    <input
                        type="radio"
                        name="ikut_ronda"
                        value="1"
                        x-model="ikutRonda"
                    >

                    Saya ikut ronda

                </label>

                <label class="flex items-center gap-3">

                    <input
                        type="radio"
                        name="ikut_ronda"
                        value="0"
                        x-model="ikutRonda"
                    >

                    Saya tidak ronda

                </label>

            </div>

            <!-- Tanggal Ronda -->
            <div
                class="mb-5"
                x-show="ikutRonda == 1 && ipl > 0"
                x-transition
            >

                <label class="block mb-2 font-semibold">

                    Tanggal Ronda

                </label>

                <input
                    type="date"
                    name="tanggal_ronda"
                    class="w-full rounded-2xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"
                >

            </div>

            <!-- Rincian -->
            <div
                class="bg-slate-50 rounded-3xl p-5 mb-6"
                x-show="ipl > 0"
                x-transition
            >

                <h2 class="font-bold text-lg mb-5">

                    Rincian Pembayaran

                </h2>

                <!-- IPL -->
                <div class="flex justify-between mb-3">

                    <span>

                        IPL

                    </span>

                    <span>

                        Rp
                        <span x-text="ipl.toLocaleString('id-ID')"></span>

                    </span>

                </div>

                <!-- Kas -->
                <div class="flex justify-between mb-3">

                    <span>

                        Kas Cluster

                    </span>

                    <span>

                        Rp 5.000

                    </span>

                </div>

                <!-- Denda -->
                <div
                    class="flex justify-between mb-3"
                    x-show="ikutRonda == 0"
                >

                    <span>

                        Denda Tidak Ronda

                    </span>

                    <span>

                        Rp 20.000

                    </span>

                </div>

                <hr class="my-4">

                <!-- Total -->
                <div class="flex justify-between text-xl font-bold text-teal-700">

                    <span>

                        Total

                    </span>

                    <span>

                        Rp
                        <span x-text="total"></span>

                    </span>

                </div>

            </div>

            <!-- Upload -->
            <div
                class="mb-6"
                x-show="ipl > 0"
                x-transition
            >

                <label class="block mb-2 font-semibold">

                    Upload Bukti Pembayaran

                </label>

                <input
                    type="file"
                    name="bukti_bayar"
                    class="w-full"
                    required
                >

            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-teal-600 hover:bg-teal-700 text-white py-4 rounded-2xl font-semibold transition"
            >

                Kirim Pembayaran

            </button>

        </form>

    </div>

</div>



<script>

const rukem =
    {{ auth()->user()->resident->rukem ?? 1 }};

function paymentForm()
{
    return {

        periode: '',

        ikutRonda: 1,

        ipl: 0,

        init()
        {
            this.$watch('periode', (value) => {

                /*
                |--------------------------------------------------------------------------
                | RESET
                |--------------------------------------------------------------------------
                */

                if(!value)
                {
                    this.ipl = 0;
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | SPLIT
                |--------------------------------------------------------------------------
                */

                let split = value.split('|');

                let bulan = parseInt(split[0]);

                let tahun = parseInt(split[1]);

                /*
                |--------------------------------------------------------------------------
                | IPL DASAR
                |--------------------------------------------------------------------------
                |
                | Jan-Mei 2026 = 75rb
                | Juni dst     = 55rb
                |
                */

                let iplDasar = 55000;

                if(
                    tahun == 2026
                    &&
                    bulan <= 5
                ) {

                    iplDasar = 75000;
                }

                /*
                |--------------------------------------------------------------------------
                | TAMBAHAN RUKEM
                |--------------------------------------------------------------------------
                |
                | rukem 1 = +0
                | rukem 2 = +5000
                | rukem 3 = +10000
                |
                */

                let tambahanRukem =
                    Math.max(rukem - 1, 0) * 5000;

                /*
                |--------------------------------------------------------------------------
                | TOTAL IPL
                |--------------------------------------------------------------------------
                */

                this.ipl =
                    iplDasar +
                    tambahanRukem;

            });
        },

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        get total()
        {
            if(this.ipl == 0)
            {
                return 0;
            }

            let total =
                this.ipl + 5000;

            if(this.ikutRonda == 0)
            {
                total += 20000;
            }

            return total.toLocaleString('id-ID');
        }
    }
}

</script>

@endsection