<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_toko',
        'deskripsi',
        'alamat',
        'telepon',
        'status',
        'catatan_admin',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'tipe_pembayaran',
        'nama_ewallet',
        'nomor_ewallet',
        'nama_pemilik_ewallet',
        'gambar_qris',
        'gunakan_rajaongkir',
        'kota_asal_id',
        'kota_asal_nama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
