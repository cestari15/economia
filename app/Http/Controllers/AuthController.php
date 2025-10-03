<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Adm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registrar novo cliente
     */
    public function register(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email',
            'cpf' => 'required|string|digits:11|unique:clientes,cpf',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cria cliente
        $cliente = Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cadastro realizado com sucesso!',
            'data' => $cliente
        ], 201);
    }

    /**
     * Login unificado (cliente ou admin)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = null;
        $tipo = null;

        // Tenta admin
        $adm = Adm::where('email', $request->email)->first();
        if ($adm && Hash::check($request->password, $adm->password)) {
            $user = $adm;
            $tipo = 'admin';
        }

        // Tenta cliente se não for admin
        if (!$user) {
            $cliente = Cliente::where('email', $request->email)->first();
            if ($cliente && Hash::check($request->password, $cliente->password)) {
                $user = $cliente;
                $tipo = 'cliente';
            }
        }

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email ou senha incorretos.'
            ], 401);
        }

        // Gera token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login realizado com sucesso!',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'nome' => $user->nome ?? $user->name,
                'email' => $user->email,
                'tipo' => $tipo
            ]
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout realizado com sucesso!'
        ]);
    }
}
