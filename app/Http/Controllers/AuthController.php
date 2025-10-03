<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registrar novo cliente
     */
    public function register(Request $request)
    {
        // validação
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

        // cria cliente
        $cliente = Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf), // garante só números
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cadastro realizado com sucesso!',
            'data' => $cliente
        ], 201);
    }

    /**
     * Login do cliente
     */
    public function login(LoginRequest $request)
    {
        $cliente = Cliente::where('email', $request->email)->first();

        if (!$cliente || !Hash::check($request->password, $cliente->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email ou senha incorretos.'
            ], 401);
        }

        // Gera token Sanctum
        $token = $cliente->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login realizado com sucesso!',
            'data' => $cliente,
            'token' => $token
        ]);
    }

    /**
     * Logout do cliente
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
