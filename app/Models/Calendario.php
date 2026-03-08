<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'title',
        'data_evento',
        'dias_lembrete'
    ];

    protected $dates = [
        'data_evento'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function dataLembrete()
    {
        if ($this->dias_lembrete > 0) {
            return Carbon::parse($this->data_evento)->subDays($this->dias_lembrete);
        }

        return null;
    }
}