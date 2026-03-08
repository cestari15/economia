<?php

namespace App\Http\Controllers;

use App\Models\Anotacoes;
use Illuminate\Http\Request;
use App\Http\Requests\AnotacoesFormRequest;

class AnotacoesController extends Controller
{
    // Retorna todas as anotações do usuário logado
    public function retornarTodos(Request $request)
    {

        $user = $request->user();

        $anotacoes = Anotacoes::where('cliente_id', $user->id)->get();

        return response()->json([
            'status' => true,
            'data' => $anotacoes
        ], 200);
    }

    public function store(AnotacoesFormRequest $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não autenticado.'
            ], 401);
        }

        $anotacao = Anotacoes::create([
            'nome'       => $request->nome,
            'categoria'  => $request->categoria,
            'valor'      => $request->valor,
            'data'       => $request->data,
            'cliente_id' => $user->id, // agora o ID vem do admin ou cliente logado
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Anotação cadastrada com sucesso',
            'data'    => $anotacao
        ], 200);
    }


    public function editar(AnotacoesFormRequest $request)
    {
        $user = $request->user();

        $anotacao = Anotacoes::where('id', $request->id)
            ->where('cliente_id', $user->id)
            ->first();

        if (!$anotacao) {
            return response()->json([
                'status' => false,
                'message' => 'Anotação não encontrada.'
            ], 404);
        }

        $anotacao->update($request->only(['nome', 'categoria', 'valor', 'data']));

        return response()->json([
            'status' => true,
            'message' => 'Anotação atualizada com sucesso',
            'data' => $anotacao
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $anotacao = Anotacoes::where('id', $id)
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
