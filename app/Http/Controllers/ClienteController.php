<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteFormRequest;
use App\Http\Requests\ClienteFormRequestUpdate;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function store(ClienteFormRequest $request)
    {
        $clientes = Cliente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "Cliente cadastrado com sucesso",
            "data" => $clientes
        ], 200);
    }

    public function delete($id)
    {
        $clientes = Cliente::find($id);

        if (!isset($clientes)) {
            return response()->json([
                'status' => false,
                'message' => "Cliente não Sencontrado"
            ]);
        }

        $clientes->delete();
        return response()->json([
            'status' => true,
            'message' => "Cliente excluido com sucesso"
        ]);
    }




    public function editar(ClienteFormRequestUpdate $request)
    {

        $clientes = Cliente::find($request->id);

        if (!isset($clientes)) {
            return response()->json([
                'status' => false,
                'message' => "Cliente não Sencontrado"
            ]);
        }

        if (isset($request->nome)) {
            $clientes->nome = $request->nome;
        }


        if (isset($request->cpf)) {
            $clientes->cpf = $request->cpf;
        }

        if (isset($request->email)) {
            $clientes->email = $request->email;
        }


        if (isset($request->password)) {
            $clientes->password = Hash::make($request->password);
        }


        $clientes->update();

        return response()->json([
            'status' => true,
            'message' => 'Cliente atualizado.'
        ]);
    }


    public function retornarTodos()
    {
        $clientes = Cliente::all();

        if ($clientes == null) {
            return response()->json([
                'status' => false,
                'message' => 'Nenhum cliente cadastrado'
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $clientes
        ]);
    }

     public function listarClientes(Request $request)
    {
        $user = $request->user();

        // Verifica se é admin
        if ($user->tipo !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Acesso negado'
            ], 403);
        }

        $clientes = Cliente::orderBy('created_at', 'desc')->get();

        if ($clientes->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Nenhum cliente cadastrado.'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $clientes
        ]);
    }

    public function pesquisar(Request $request)
    {

        $query = Cliente::query();

        $query->where(function ($q) use ($request) {
            $q->where('nome', 'like', '%' . $request->input('pesquisa') . '%')
             ->orWhere('email', 'like', '%' . $request->input('pesquisa') . '%')
                ->orWhere('cpf', 'like', '%' . $request->input('pesquisa') . '%');
        });

        $clientes = $query->get();
        if (count($clientes) > 0) {
            return response()->json([
                'status' => true,
                'data' => $clientes
            ]);
        }
        return response()->json([
            'status' => false,
            'data' => "Nenhum resultado encontrado"
        ]);
    }

    public function pesquisarPorId($id)
    {
        $clientes = Cliente::find($id);
        if ($clientes == null) {
            return response()->json([
                'status' => false,
                'message' => "cliente não encontrado"
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $clientes
        ]);
    }


    public function recuperarSenha(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $clientes = Cliente::where('email', $request->email)->first();

        if (!$clientes) {
            return response()->json([
                'status' => false,
                'message' => 'Email inválido'
            ], 404);
        }

        // Gerar token de redefinição de senha (ex: UUID ou hash)
        $token = bin2hex(random_bytes(20));

        // Salvar token na tabela de password resets ou enviar email
        // Exemplo simples:
        // PasswordReset::create(['email' => $adm->email, 'token' => $token]);

        // Aqui você enviaria o token por e-mail para o usuário
        // Mail::to($adm->email)->send(new ResetPasswordMail($token));

        return response()->json([
            'status' => true,
            'message' => 'Instruções para redefinir a senha foram enviadas para seu e-mail.'
        ]);
    }
}
