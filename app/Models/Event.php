<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Event extends Model
{
    use HasFactory; // <- ini wajib dipanggil

    protected $fillable = [
        'nama',
        'tanggal',
        'lokasi',
        'harga',
        'kategori',
        'deskripsi',
        'kuota',
        'maks_pemesanan',
        'status',
        'user_id',
        'gambar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wishlists()
    {
    return $this->hasMany(Wishlist::class);
    }

}
