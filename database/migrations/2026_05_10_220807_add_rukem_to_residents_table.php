<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {

            $table->integer('rukem')
                  ->default(1)
                  ->after('status_rumah');

        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {

            $table->dropColumn('rukem');

        });
    }
};