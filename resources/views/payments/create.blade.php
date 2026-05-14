@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto px-4 py-6 pb-28 md:pb-6">

    <div class="glass rounded-[32px] border border-white/40 p-5 shadow-2xl shadow-slate-200/60 md:p-8">

        <!-- Header -->
        <div class="mb-6 sm:mb-8">

            <h1 class="mb-2 text-3xl font-bold tracking-tight text-teal-700">

                Upload Pembayaran

            </h1>

            <p class="text-slate-500">

                Pembayaran IPL Delima Residence

            </p>

            <!-- Welcome Card -->
            <div class="mt-4 mb-8 rounded-3xl bg-gradient-to-br from-teal-500 to-teal-700 p-6 text-white shadow-xl shadow-teal-500/20">

                <div class="mb-1 text-sm text-teal-100">
                    Selamat Datang
                </div>

                <div class="mb-4 text-2xl font-bold text-white">

                    {{ auth()->user()->name }}

                </div>

                <!-- ALWAYS 2 COLUMNS -->
                <div class="grid grid-cols-2 gap-3 text-sm">

                    <!-- Rumah -->
                    <div class="min-w-0">

                        <div class="text-teal-100 text-xs">
                            Rumah
                        </div>

                        <div class="font-semibold truncate text-sm">

                            {{ auth()->user()->resident->alamat ?? '-' }}

                        </div>

                    </div>

                    <!-- Username -->
                    <div class="min-w-0">

                        <div class="text-teal-100 text-xs">
                            Username
                        </div>

                        <div class="font-semibold truncate text-sm">

                            {{ auth()->user()->username }}

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

    <label class="block mb-2 font-semibold text-slate-700 flex items-center gap-2">

        <!-- Icon kalender -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
        </svg>

        Periode Pembayaran

    </label>

    <select
        name="periode"
        x-model="periode"
        required
        class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4
        text-slate-700 shadow-sm transition
        focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-100"
    >

        <option value="" disabled>

            Pilih Periode

        </option>

        @foreach($availablePeriods as $item)

            <option value="{{ $item['bulan'] }}|{{ $item['tahun'] }}">

                {{ $item['label'] }}

            </option>

        @endforeach

    </select>

</div>

<!-- Status Ronda -->
<div
    class="mb-5"
    x-show="periode"
    x-transition
>

    <label class="block font-semibold mb-3 text-slate-700 flex items-center gap-2">

        <!-- Icon user -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A9 9 0 1118.364 4.56 9 9 0 015.12 17.804z" />
        </svg>

        Status Ronda

    </label>

    <!-- Radio Card: Ikut -->
    <label
        class="mb-3 flex cursor-pointer items-center gap-3 rounded-2xl border px-4 py-4 transition
        bg-slate-50 border-slate-200"
        :class="ikutRonda == 1 ? 'border-teal-500 bg-teal-50' : ''"
    >

        <input
            type="radio"
            name="ikut_ronda"
            value="1"
            x-model="ikutRonda"
            class="accent-teal-600"
        >

        <span class="font-medium text-slate-700">

            Saya ikut ronda

        </span>

    </label>

    <!-- Radio Card: Tidak -->
    <label
        class="flex cursor-pointer items-center gap-3 rounded-2xl border px-4 py-4 transition
        bg-slate-50 border-slate-200"
        :class="ikutRonda == 0 ? 'border-red-400 bg-red-50' : ''"
    >

        <input
            type="radio"
            name="ikut_ronda"
            value="0"
            x-model="ikutRonda"
            class="accent-red-500"
        >

        <span class="font-medium text-slate-700">

            Saya tidak ronda

        </span>

    </label>

</div>

            <!-- Tanggal Ronda -->
            <div
                class="mb-5"
                x-show="ikutRonda == 1 && ipl > 0"
                x-transition
            >

    <label class="block mb-2 font-semibold text-slate-700 flex items-center gap-2">

        <!-- Icon kalender -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
        </svg>

        Tanggal Ronda

    </label>

    <div class="relative">

        <input
            type="date"
            name="tanggal_ronda"
            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 pl-12
            text-slate-700 shadow-sm
            transition
            focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-100"
        >

        <!-- Icon di dalam input -->
        <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
            </svg>

        </div>

    </div>

</div>

            <!-- Rincian -->
            <div
                class="mb-6 rounded-3xl border border-white/40 bg-white/70 p-5 shadow-lg backdrop-blur-xl"
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

    <label class="mb-3 block font-semibold">

        Bukti Pembayaran

    </label>

    <!-- INPUT FILE -->
    <input
        type="file"
        id="bukti_bayar"
        name="bukti_bayar"
        accept="image/*"\
        class="hidden"
        @change="
            if($event.target.files.length > 0)
            {
                preview = URL.createObjectURL(
                    $event.target.files[0]
                )
            }
        "
    >

    <!-- BUTTON -->
    <button
        type="button"
        @click="
            document
                .getElementById('bukti_bayar')
                .click()
        "
        class="w-full rounded-3xl border-2 border-dashed border-teal-200 bg-teal-50/50 p-6 text-center transition active:scale-[0.98] hover:bg-teal-50"
    >

        <div class="mb-3 text-4xl">

            📷

        </div>

        <div class="font-semibold text-slate-700">

            Pilih Foto Pembayaran

        </div>

        <div class="mt-1 text-sm text-slate-500">

            Kamera atau gallery

        </div>

    </button>

    <!-- PREVIEW -->
    <template x-if="preview">

        <div class="mt-4">

            <img
                :src="preview"
                class="w-full rounded-3xl border border-slate-200 shadow-lg"
            >

        </div>

    </template>

</div>

            <!-- Submit -->
            <button
                type="submit"
                class="h-14 w-full rounded-2xl bg-gradient-to-r from-teal-500 to-teal-700 font-semibold text-white shadow-xl shadow-teal-500/30 transition-all"
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

        preview: null,

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