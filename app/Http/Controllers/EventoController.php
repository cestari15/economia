<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    // Retorna todos os eventos
    public function index()
    {
        $eventos = Evento::all();

        return response()->json([
            'status' => true,
            'data' => $eventos
        ]);
    }

    // Adiciona novo evento
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data' => $request->data,
        ]);

        return response()->json([
            'status' => true,
            'data' => $evento,
            'message' => 'Evento criado com sucesso!'
        ], 201);
    }

    // Remove um evento pelo ID
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
