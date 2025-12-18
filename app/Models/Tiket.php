<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tiket extends Model
{
    protected $table = 'tiket';
    
    use HasFactory;

    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}