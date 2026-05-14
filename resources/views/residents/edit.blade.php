@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-6">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-teal-700">

            Edit Warga

        </h1>

    </div>

    <form
        x-data="{
            statusRumah:
                '{{ $resident->status_rumah }}'
        }"
        action="/residents/{{ $resident->id }}"
        method="POST"
        class="rounded-3xl border border-white/40 bg-white/70 p-6 shadow-2xl shadow-slate-200/60 backdrop-blur-xl"
    >

        @csrf
        @method('PUT')

        <div class="grid gap-5">

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Alamat

                </label>

                <input
                    type="text"
                    name="alamat"
                    value="{{ $resident->alamat }}"
                    class="w-full rounded-2xl border-slate-200"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Nama

                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ $resident->nama }}"
                    class="w-full rounded-2xl border-slate-200"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Status Rumah

                </label>

                <select
                    name="status_rumah"
                    x-model="statusRumah"
                    class="w-full rounded-2xl border-slate-200"
                >

                    <option value="DITEMPATI"
                        {{ $resident->status_rumah == 'DITEMPATI' ? 'selected' : '' }}>
                        DITEMPATI
                    </option>

                    <option value="TIDAK DITEMPATI"
                        {{ $resident->status_rumah == 'TIDAK DITEMPATI' ? 'selected' : '' }}>
                        TIDAK DITEMPATI
                    </option>

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Rukem

                </label>

                <input
                    type="number"
                    name="rukem"
                    value="{{ $resident->rukem }}"
                    class="w-full rounded-2xl border-slate-200"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Username

                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ $resident->user->username ?? '' }}"
                    class="w-full rounded-2xl border-slate-200"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Email

                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ $resident->user->email ?? '' }}"
                    class="w-full rounded-2xl border-slate-200"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Status User

                </label>

                <select
                    name="is_active"
                    class="w-full rounded-2xl border-slate-200"
                >

                    <option value="1"
                        {{ ($resident->user->is_active ?? 0) == 1 ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ ($resident->user->is_active ?? 0) == 0 ? 'selected' : '' }}>
                        Non Active
                    </option>

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Nomor HP

                </label>

                <div class="flex">

                    <div
                        class="flex items-center rounded-l-2xl border border-r-0 border-slate-200 bg-slate-100 px-4 text-slate-500"
                    >

                        62

                    </div>

                    <input
                        type="text"
                        name="nomor_hp"
                        value="{{ old('nomor_hp', ltrim($resident->nomor_hp, '62')) }}"
                        placeholder="81234567890"
                        class="w-full rounded-r-2xl border-slate-200"
                    >

                </div>

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Tanggal Masuk

                </label>

                <input
                    type="date"
                    name="tanggal_masuk"
                    value="{{ $resident->tanggal_masuk }}"
                    class="w-full rounded-2xl border-slate-200"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium">

                    Tanggal Keluar

                </label>

                <input
                    type="date"
                    name="tanggal_keluar"
                    :readonly="statusRumah == 'DITEMPATI'"
                    :class="
                        statusRumah == 'DITEMPATI'
                        ? 'bg-slate-100 text-slate-400'
                        : ''
                    "
                    x-effect="
                        if(
                            statusRumah == 'TIDAK DITEMPATI'
                            &&
                            !$el.value
                        ) {
                            $el.value =
                                new Date()
                                .toISOString()
                                .split('T')[0]
                        }
                    "
                    value="{{ $resident->tanggal_keluar }}"
                    class="w-full rounded-2xl border-slate-200"
                >

            </div>

            <button
                class="rounded-2xl bg-teal-600 px-6 py-3 font-semibold text-white"
            >

                Update Data

            </button>

        </div>

    </form>

</div>

@endsection