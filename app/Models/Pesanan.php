<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pesanan',
        'user_id',
        'toko_id',
        'total_harga',
        'kode_unik',
        'total_bayar',
        'status',
        'alamat_pengiriman',
        'nama_penerima',
        'telepon_penerima',
        'catatan',
        'metode_pembayaran',
        'bukti_bayar',
        'dibayar_at',
        'kurir_latitude',
        'kurir_longitude',
        'kurir_nama',
        'kurir_telepon',
        'tracking_updated_at',
    ];

    protected $casts = [
        'dibayar_at' => 'datetime',
        'tracking_updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function details()
    {
        return $this->hasMany(PesananDetail::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}
