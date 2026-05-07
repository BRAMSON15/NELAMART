<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    use HasFactory;

    protected $table = 'produk_varians';

    protected $fillable = [
        'produk_id',
        'nama_varian',
        'tipe_varian',
        'harga_tambahan',
        'stok',
        'sku',
        'gambar',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function getHargaFinalAttribute()
    {
        return $this->produk->harga + $this->harga_tambahan;
    }
}
