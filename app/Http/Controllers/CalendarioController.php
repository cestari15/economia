<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    /**
     * Mudamos de 'index' para 'listar' para bater com o api.php
     * E mudamos Auth::guard('cliente') para Auth::user() para funcionar com Sanctum
     */
    public function listar()
    {
        $user = Auth::user();
        $calendarios = Calendario::where('cliente_id', $user->id)->get();
        $eventos = [];

        foreach ($calendarios as $cal) {
            $dataBase = Carbon::parse($cal->data_evento);
            $mesesParaGerar = $cal->recorrente ? 12 : 1;

            for ($i = 0; $i < $mesesParaGerar; $i++) {
                $dataInstancia = $dataBase->copy()->addMonths($i);

                $eventos[] = [
                    'id' => $cal->id . '_' . $i,
                    'title' => $cal->title,
                    'start' => $dataInstancia->format('Y-m-d'),
                    'tipo' => 'evento'
                ];
            }
        }
        return response()->json($eventos);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Adicionamos 'dia_lembrete' na validação
        $request->validate([
            'title' => 'required|string',
            'data_evento' => 'required|date',
            'recorrente' => 'boolean',
            'dia_lembrete' => 'nullable|integer|min:0|max:31' // Validação do novo campo
        ]);

        // 2. Adicionamos 'dias_lembrete' no salvamento (conforme sua migration)
        $calendario = Calendario::create([
            'cliente_id'    => $user->id,
            'title'         => $request->title,
            'data_evento'   => $request->data_evento,
            'recorrente'    => $request->recorrente ?? false,
            'dias_lembrete' => $request->dia_lembrete ?? 0 // Salva o dia vindo do JS
        ]);

        return response()->json(['status' => true, 'data' => $calendario]);
    }

   

    public function destroy($id)
    {
        $user = Auth::user();

        // Divide a string pelo underline e pega apenas a primeira parte (o ID real do banco)
        // Exemplo: "12_0" vira "12"
        $idReal = explode('_', $id)[0];

        $evento = Calendario::where('id', $idReal)
            ->where('cliente_id', $user->id)
            ->first();

        if (!$evento) {
            return response()->json([
                'status' => false,
                'message' => 'Evento não encontrado (ID buscado: ' . $idReal . ')'
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'status' => true,
            'message' => 'Evento removido com sucesso'
        ]);
    }
}
