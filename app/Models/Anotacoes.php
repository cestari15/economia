<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anotacoes extends Model
{
    use HasFactory;

    protected $table = 'anotacoes'; // nome da tabela

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'cliente_id',  // relacionamento com o cliente
        'titulo',
        'descricao',
        'categoria',   // opcional, se quiser filtrar depois
        'data'         // data da anotação, se necessário
    ];

    // Definindo o relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
