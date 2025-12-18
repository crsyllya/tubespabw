<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyelenggara extends Authenticatable
{
    use HasFactory;
    protected $table = 'penyelenggaras';
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

    // Tambahkan default value untuk is_active
    protected $attributes = [
        'is_active' => true,
    ];
}