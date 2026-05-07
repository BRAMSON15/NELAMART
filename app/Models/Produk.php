<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'gambar',
        'status',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function pesananDetails()
    {
        return $this->hasMany(PesananDetail::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }

    public function varians()
    {
        return $this->hasMany(ProdukVarian::class);
    }

    public function getTotalStokAttribute()
    {
        if ($this->varians()->exists()) {
            return $this->varians()->sum('stok');
        }
        return $this->stok;
    }
}
