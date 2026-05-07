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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->decimal('kurir_latitude', 10, 8)->nullable()->after('metode_pembayaran');
            $table->decimal('kurir_longitude', 11, 8)->nullable()->after('kurir_latitude');
            $table->string('kurir_nama')->nullable()->after('kurir_longitude');
            $table->string('kurir_telepon')->nullable()->after('kurir_nama');
            $table->timestamp('tracking_updated_at')->nullable()->after('kurir_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['kurir_latitude', 'kurir_longitude', 'kurir_nama', 'kurir_telepon', 'tracking_updated_at']);
        });
    }
};
