<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah nilai lama ke nilai baru dulu sebelum ganti ENUM
        DB::statement("UPDATE tokos SET status = 'aktif' WHERE status = 'verified'");
        DB::statement("UPDATE tokos SET status = 'ditolak' WHERE status = 'rejected'");

        // Ganti definisi ENUM
        DB::statement("ALTER TABLE tokos MODIFY COLUMN status ENUM('pending', 'aktif', 'ditolak') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("UPDATE tokos SET status = 'verified' WHERE status = 'aktif'");
        DB::statement("UPDATE tokos SET status = 'rejected' WHERE status = 'ditolak'");

        DB::statement("ALTER TABLE tokos MODIFY COLUMN status ENUM('pending', 'verified', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
