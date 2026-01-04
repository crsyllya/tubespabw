<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Pengunjung extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pengunjungs';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'pengunjung_id');
    }
}
