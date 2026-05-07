<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_varians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('nama_varian');  // contoh: Merah, XL, Vanilla
            $table->string('tipe_varian')->nullable(); // contoh: Warna, Ukuran, Rasa
            $table->decimal('harga_tambahan', 12, 2)->default(0); // tambahan dari harga dasar
            $table->integer('stok')->default(0);
            $table->string('sku')->nullable(); // kode produk varian
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_varians');
    }
};
