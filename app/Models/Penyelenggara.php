<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Penyelenggara extends Authenticatable
{
    use HasApiTokens, HasFactory;

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

    protected $attributes = [
        'is_active' => true,
    ];
}
