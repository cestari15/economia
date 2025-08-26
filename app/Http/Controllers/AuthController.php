<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // ou User, se usar a tabela users
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validação simples
        $request->validate([
            'cpf' => 'required|string', // ou 'email' se usar email
            'password' => 'required|string',
        ]);

        // Buscar usuário pelo CPF
        $cliente = Cliente::where('cpf', $request->cpf)->first();

        if (!$cliente || !Hash::check($request->password, $cliente->password)) {
            return response()->json([
                'status' => false,
                'message' => 'CPF ou senha incorretos'
            ], 401);
        }

        // Aqui você pode gerar um token (por exemplo JWT ou Sanctum)
        // Para simplificar, vamos retornar o usuário logado
        return response()->json([
            'status' => true,
            'message' => 'Login realizado com sucesso',
            'data' => $cliente
        ]);
    }
}
