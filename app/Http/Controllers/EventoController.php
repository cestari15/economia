<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{
    // Listar todos os eventos
    public function index()
    {
        $eventos = Evento::all();
        return response()->json([
            'status' => true,
            'data' => $eventos
        ]);
    }

    // Salvar um novo evento
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'reminder_days_before' => 'nullable|integer|min:0'
        ]);

        $evento = Evento::create([
            'title' => $request->title,
            'start' => $request->start,
            'reminder_days_before' => $request->reminder_days_before ?? 0,
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Evento criado com sucesso!',
            'data' => $evento
        ]);
    }
}
