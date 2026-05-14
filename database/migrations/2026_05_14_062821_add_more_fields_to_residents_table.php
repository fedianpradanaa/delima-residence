<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {

            $table->string('nomor_hp')
                ->nullable()
                ->after('nama');

            $table->date('tanggal_masuk')
                ->nullable()
                ->after('nomor_hp');

            $table->date('tanggal_keluar')
                ->nullable()
                ->after('tanggal_masuk');
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {

            $table->dropColumn([

                'nomor_hp',

                'tanggal_masuk',

                'tanggal_keluar',
            ]);
        });
    }
};