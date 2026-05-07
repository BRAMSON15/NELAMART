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
            $table->boolean('gunakan_rajaongkir')->default(false)->after('gambar_qris');
            $table->string('kota_asal_id')->nullable()->after('gunakan_rajaongkir');
            $table->string('kota_asal_nama')->nullable()->after('kota_asal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn(['gunakan_rajaongkir', 'kota_asal_id', 'kota_asal_nama']);
        });
    }
};
