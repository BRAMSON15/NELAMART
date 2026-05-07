<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Kode unik 3 digit (1–999) yang ditambahkan ke total harga QRIS
            // untuk membantu penjual memverifikasi keaslian pembayaran
            $table->unsignedSmallInteger('kode_unik')->nullable()->after('metode_pembayaran');
            // Total yang benar-benar harus dibayar (total_harga + kode_unik)
            $table->unsignedBigInteger('total_bayar')->nullable()->after('kode_unik');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['kode_unik', 'total_bayar']);
        });
    }
};
