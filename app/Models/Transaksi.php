<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Tiket::class, 'transaksi_id');
    }

    public function getStatusLabelAttribute()
    {
    return match ($this->status) {
        'pending' => '<span class="badge warning">Menunggu Pembayaran</span>',
        'verifying' => '<span class="badge info">Dalam Verifikasi</span>',
        'success' => '<span class="badge success">Berhasil Dibeli</span>',
        'rejected' => '<span class="badge danger">Ditolak</span>',
        'expired' => '<span class="badge dark">Hangus</span>',
        default => '<span class="badge secondary">Unknown</span>',
    };
}
public function pengunjung()
{
    return $this->belongsTo(Pengunjung::class, 'pengunjung_id');
}

}