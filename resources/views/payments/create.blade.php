@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto px-4 py-6 pb-28 md:pb-6">

    <div class="glass rounded-[32px] border border-white/40 p-5 shadow-2xl shadow-slate-200/60 md:p-8">

        <!-- Header -->
        <div class="mb-8">

            <h1 class="mb-2 text-3xl font-bold tracking-tight text-teal-700">

                Upload Pembayaran

            </h1>

            <p class="text-slate-500">

                Pembayaran IPL Delima Residence

            </p>

            <!-- Welcome Card -->
            <div class="mb-8 rounded-3xl bg-gradient-to-br from-teal-500 to-teal-700 p-6 text-white shadow-xl shadow-teal-500/20">

                <div class="mb-1 text-sm text-teal-100">
                    Selamat Datang
                </div>

                <div class="mb-4 text-2xl font-bold text-white">

                    {{ auth()->user()->name }}

                </div>

                <div class="flex flex-wrap gap-4 text-sm">

                    <div class="min-w-[140px] flex-1">

                        <div class="text-teal-100">
                            Rumah
                        </div>

                        <div class="font-semibold">

                            {{ auth()->user()->resident->alamat ?? '-' }}

                        </div>

                    </div>

                    <div class="min-w-[140px] flex-1">

                        <div class="text-teal-100">
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
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-100"
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
            <div
                class="mb-5"
                x-show="periode"
                x-transition
            >

                <label class="block font-semibold mb-3">

                    Status Ronda

                </label>

                <label class="mb-3 flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">

                    <input
                        type="radio"
                        name="ikut_ronda"
                        value="1"
                        x-model="ikutRonda"
                    >

                    Saya ikut ronda

                </label>

                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">

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
                        style="min-height:48px"
                        class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-100"
                    >

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
                x-data="{ openPicker:false }"
                x-show="ipl > 0"
                x-transition
            >

                <label class="mb-3 block font-semibold">

                    Bukti Pembayaran

                </label>

                <!-- INPUT CAMERA -->
                <input
                    type="file"
                    id="camera_input"
                    name="bukti_bayar"
                    accept="image/*"
                    capture="environment"
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

                <!-- INPUT GALLERY -->
                <input
                    type="file"
                    id="gallery_input"
                    name="bukti_bayar"
                    accept="image/*"
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
                    @click="openPicker = true"
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

                <!-- MODAL PICKER -->
                <div
                    x-show="openPicker"
                    x-transition
                    class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 p-4"
                >

                    <div
                        @click.away="openPicker = false"
                        class="w-full max-w-md rounded-3xl bg-white p-4 shadow-2xl"
                    >

                        <div class="mb-4 text-center text-lg font-bold">

                            Pilih Sumber Foto

                        </div>

                        <!-- CAMERA -->
                        <button
                            type="button"
                            @click="
                                document.getElementById('camera_input').click();
                                openPicker = false;
                            "
                            class="mb-3 w-full rounded-2xl bg-teal-600 px-4 py-4 font-semibold text-white"
                        >

                            📷 Ambil dari Kamera

                        </button>

                        <!-- GALLERY -->
                        <button
                            type="button"
                            @click="
                                document.getElementById('gallery_input').click();
                                openPicker = false;
                            "
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 font-semibold text-slate-700"
                        >

                            🖼 Ambil dari Gallery

                        </button>

                    </div>

                </div>

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