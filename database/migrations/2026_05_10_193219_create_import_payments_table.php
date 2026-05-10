<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('import_payments', function (Blueprint $table) {

            $table->id();

            $table->string('alamat')->nullable();

            $table->string('nama')->nullable();

            $table->string('status_rumah')->nullable();

            $table->date('tanggal')->nullable();

            $table->string('bulan')->nullable();

            $table->string('type_iuran')->nullable();

            $table->bigInteger('nominal')->default(0);

            $table->string('temp_status')->nullable();

            $table->string('status')->nullable();

            $table->string('bulan_angka')->nullable();

            $table->text('remark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_payments');
    }
};