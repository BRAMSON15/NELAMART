<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            // Tipe metode pembayaran: bank, ewallet, atau keduanya
            $table->string('tipe_pembayaran', 20)->default('bank')->after('nama_pemilik_rekening');
            // E-wallet
            $table->string('nama_ewallet', 50)->nullable()->after('tipe_pembayaran');
            $table->string('nomor_ewallet', 50)->nullable()->after('nama_ewallet');
            $table->string('nama_pemilik_ewallet', 100)->nullable()->after('nomor_ewallet');
        });
    }

    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn(['tipe_pembayaran', 'nama_ewallet', 'nomor_ewallet', 'nama_pemilik_ewallet']);
        });
    }
};
