<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->integer('bulan');

            $table->integer('tahun');

            $table->boolean('ikut_ronda');

            $table->date('tanggal_ronda')->nullable();

            $table->integer('nominal_ipl');

            $table->integer('nominal_kas');

            $table->integer('nominal_denda')->default(0);

            $table->integer('total');

            $table->string('bukti_bayar');

            $table->enum('status_verifikasi', [
                'pending',
                'diterima',
                'ditolak'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};