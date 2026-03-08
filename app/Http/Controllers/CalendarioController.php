<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{

    public function index()
    {
        $cliente = Auth::guard('cliente')->user();

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'message' => 'Cliente não autenticado'
            ], 401);
        }

        $calendarios = Calendario::where('cliente_id', $cliente->id)->get();

        $eventos = [];

        foreach ($calendarios as $calendario) {

            // Evento principal
            $eventos[] = [
                'id' => $calendario->id,
                'title' => $calendario->title,
                'date' => $calendario->data_evento,
                'tipo' => 'evento'
            ];

            // Lembrete
            if ($calendario->dias_lembrete > 0) {

                $dataLembrete = Carbon::parse($calendario->data_evento)
                    ->subDays($calendario->dias_lembrete);

                $eventos[] = [
                    'id' => 'reminder_'.$calendario->id,
                    'title' => 'Lembrete: '.$calendario->title,
                    'date' => $dataLembrete->format('Y-m-d'),
                    'tipo' => 'lembrete'
                ];
            }
        }

        return response()->json($eventos);
    }

    public function store(Request $request)
    {
        $cliente = Auth::guard('cliente')->user();

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'message' => 'Cliente não autenticado'
            ], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'data_evento' => 'required|date',
            'dias_lembrete' => 'nullable|integer'
        ]);

        $calendario = Calendario::create([
            'cliente_id' => $cliente->id,
            'title' => $request->title,
            'data_evento' => $request->data_evento,
            'dias_lembrete' => $request->dias_lembrete ?? 0
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Evento criado com sucesso',
            'data' => $calendario
        ]);
    }

    public function destroy($id)
    {
        $cliente = Auth::guard('cliente')->user();

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'message' => 'Cliente não autenticado'
            ], 401);
        }

        $evento = Calendario::where('id', $id)
            ->where('cliente_id', $cliente->id)
            ->first();

        if (!$evento) {
            return response()->json([
                'status' => false,
                'message' => 'Evento não encontrado'
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'status' => true,
            'message' => 'Evento removido'
        ]);
    }
}