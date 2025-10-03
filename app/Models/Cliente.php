<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // ✅ IMPORTANTE
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // ✅ Adicione HasApiTokens

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function anotacoes()
    {
        return $this->hasMany(Anotacaoes::class);
    }
}
