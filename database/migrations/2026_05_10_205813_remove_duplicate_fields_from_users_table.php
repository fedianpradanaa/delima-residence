<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([

                'blok',

                'nomor_rumah',

                'alamat'

            ]);

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('blok')->nullable();

            $table->string('nomor_rumah')->nullable();

            $table->string('alamat')->nullable();

        });
    }
};