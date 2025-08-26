<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnotacoesFormRequest;
use App\Http\Requests\AnotacoesFormRequestUpdate;
use App\Models\Anotacoes;
use Illuminate\Http\Request;

class AnotacoesController extends Controller
{
    public function store(AnotacoesFormRequest $request)
    {
        $anotacoes = Anotacoes::create([
            'nome' => $request->nome,
            'categoria' => $request->categoria,
            'valor' => $request->valor,
            'data' => $request->data,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Anotação cadastrada com sucesso",
            "data" => $anotacoes
        ], 200);
    }

    public function delete($id)
    {
        $anotacoes = Anotacoes::find($id);

        if (!isset($anotacoes)) {
            return response()->json([
                'status' => false,
                'message' => "Anotação não encontrada"
            ]);
        }

        $anotacoes->delete();
        return response()->json([
            'status' => true,
            'message' => "Anotação excluida com sucesso"
        ]);
    }




    public function editar(AnotacoesFormRequestUpdate $request)
    {

        $anotacoes = Anotacoes::find($request->id);

        if (!isset($anotacoes)) {
            return response()->json([
                'status' => false,
                'message' => "anotação não encontrada"
            ]);
        }

        if (isset($request->nome)) {
            $anotacoes->nome = $request->nome;
        }

        if (isset($request->categoria)) {
            $anotacoes->categoria = $request->categoria;
        }

        if (isset($request->valor)) {
            $anotacoes->valor = $request->valor;
        }


        if (isset($request->data)) {
            $anotacoes->data = $request->data;
        }

        $anotacoes->update();

        return response()->json([
            'status' => true,
            'message' => 'anotação atualizado.'
        ]);
    }


    public function retornarTodos()
    {
        $anotacoes = Anotacoes::all();

        if ($anotacoes == null) {
            return response()->json([
                'status' => false,
                'message' => 'Nenhuma Anotação cadastrada'
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $anotacoes
        ]);
    }


    public function pesquisar(Request $request)
    {

        $query = Anotacoes::query();

        $query->where(function ($q) use ($request) {
            $q->where('nome', 'like', '%' . $request->input('pesquisa') . '%')
                ->orWhere('categoria', 'like', '%' . $request->input('pesquisa') . '%');
        });

        $anotacoes = $query->get();
        if (count($anotacoes) > 0) {
            return response()->json([
                'status' => true,
                'data' => $anotacoes
            ]);
        }
        return response()->json([
            'status' => false,
            'data' => "Nenhum resultado encontrado"
        ]);
    }

    public function pesquisarPorId($id)
    {
        $anotacoes = Anotacoes::find($id);
        if ($anotacoes == null) {
            return response()->json([
                'status' => false,
                'message' => "Anotação não encontrada"
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $anotacoes
        ]);
    }
}
