<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Http\Requests\EventoRequest;
use App\Http\Requests\StoreEventoRequest;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    // Retorna todos os eventos do usuário logado
    public function index()
    {
        $eventos = Evento::all(); // ou filtrar pelo user_id
        return response()->json([
            'status' => true,
            'data' => $eventos
        ]);
    }

    // Adiciona novo evento
    public function store(StoreEventoRequest $request)
    {
        $evento = Evento::create([
            'title' => $request->title,
            'start' => $request->start,
            'reminder_days_before' => $request->reminder_days_before ?? 5,
            'user_id' => auth()->id(), // garante o vínculo com o usuário logado
        ]);

        return response()->json([
            'status' => true,
            'data' => $evento,
            'message' => 'Evento criado com sucesso!'
        ], 201);
    }

    // Remove evento
    public function destroy($id)
    {
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json([
                'status' => false,
                'message' => 'Evento não encontrado'
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'status' => true,
            'message' => 'Evento removido com sucesso!'
        ]);
    }
}
