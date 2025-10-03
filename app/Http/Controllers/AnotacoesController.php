<?php

namespace App\Http\Controllers;

use App\Models\Anotacao;
use Illuminate\Http\Request;
use App\Http\Requests\AnotacoesFormRequest;
use App\Models\Anotacaoes;

class AnotacoesController extends Controller
{
    // Retorna todas as anotações do usuário logado
    public function retornarTodos(Request $request)
    {
        $user = $request->user(); // Usuário logado via Sanctum

        $anotacoes = Anotacaoes::where('cliente_id', $user->id)->get();

        return response()->json([
            'status' => true,
            'data' => $anotacoes
        ], 200);
    }

    // Cria uma nova anotação associada ao usuário logado
    public function store(AnotacoesFormRequest $request)
    {
        $user = $request->user(); // Usuário logado

        $anotacao = Anotacaoes::create([
            'nome'       => $request->nome,
            'categoria'  => $request->categoria,
            'valor'      => $request->valor,
            'data'       => $request->data,
            'cliente_id' => $user->id, // associa a anotação ao cliente
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Anotação cadastrada com sucesso',
            'data' => $anotacao
        ], 200);
    }

    // Edita uma anotação do usuário logado
    public function editar(AnotacoesFormRequest $request)
    {
        $user = $request->user();

        $anotacao = Anotacaoes::where('id', $request->id)
            ->where('cliente_id', $user->id)
            ->first();

        if (!$anotacao) {
            return response()->json([
                'status' => false,
                'message' => 'Anotação não encontrada.'
            ], 404);
        }

        $anotacao->update([
            'nome'      => $request->nome,
            'categoria' => $request->categoria,
            'valor'     => $request->valor,
            'data'      => $request->data,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Anotação atualizada com sucesso',
            'data' => $anotacao
        ], 200);
    }

    // Deleta uma anotação do usuário logado
    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $anotacao = Anotacaoes::where('id', $id)
            ->where('cliente_id', $user->id)
            ->first();

        if (!$anotacao) {
            return response()->json([
                'status' => false,
                'message' => 'Anotação não encontrada.'
            ], 404);
        }

        $anotacao->delete();

        return response()->json([
            'status' => true,
            'message' => 'Anotação deletada com sucesso'
        ], 200);
    }
}
