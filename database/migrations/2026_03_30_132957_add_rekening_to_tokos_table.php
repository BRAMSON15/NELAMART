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
        Schema::table('tokos', function (Blueprint $table) {
            $table->string('nama_bank')->nullable()->after('telepon');
            $table->string('nomor_rekening', 30)->nullable()->after('nama_bank');
            $table->string('nama_pemilik_rekening')->nullable()->after('nomor_rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn(['nama_bank', 'nomor_rekening', 'nama_pemilik_rekening']);
        });
    }
};
