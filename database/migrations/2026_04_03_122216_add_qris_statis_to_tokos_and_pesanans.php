<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Toko: tambah kolom gambar QRIS statis
        Schema::table('tokos', function (Blueprint $table) {
            $table->string('gambar_qris')->nullable()->after('nama_pemilik_ewallet');
        });

        // Pesanan: tambah bukti bayar (upload screenshot transfer/QRIS)
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('bukti_bayar')->nullable()->after('metode_pembayaran');
            $table->timestamp('dibayar_at')->nullable()->after('bukti_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn('gambar_qris');
        });
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['bukti_bayar', 'dibayar_at']);
        });
    }
};
