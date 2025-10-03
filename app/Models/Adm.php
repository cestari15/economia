<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Adm extends Model
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
