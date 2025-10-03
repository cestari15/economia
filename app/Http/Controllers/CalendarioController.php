<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    // Retorna a view do calendário
    public function index()
    {
        return view('calendario');
    }

    // Retorna todos os eventos do usuário logado em formato FullCalendar
    public function eventos()
    {
        $user = Auth::user();
        $eventos = Evento::where('user_id', $user->id)->get();

        // Transformar no formato que o FullCalendar espera
        $fullcalendarEvents = $eventos->map(function($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->data,
                'allDay' => true,
            ];
        });

        return response()->json($fullcalendarEvents);
    }

    // Cria um evento para o usuário logado
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'data' => 'required|date',
            'dias_antes' => 'required|integer|min:0',
            'email' => 'required|email',
        ]);

        $user = Auth::user();

        $evento = Evento::create([
            'user_id' => $user->id,
            'titulo' => $request->titulo,
            'data' => $request->data,
            'reminder_days_before' => $request->dias_antes,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Evento criado com sucesso!',
            'evento' => $evento
        ]);
    }
}
