<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <- importante
use Laravel\Sanctum\HasApiTokens;

class Adm extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
}
