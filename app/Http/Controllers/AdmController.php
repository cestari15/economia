<?php

namespace App\Http\Controllers;

use App\Models\Adm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdmController extends Controller
{
    // Login do administrador
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $adm = Adm::where('email', $request->email)->first();

        if (!$adm || !Hash::check($request->password, $adm->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email ou senha inválidos.'],
            ]);
        }

        $token = $adm->createToken('adm-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'token' => $token,
            'adm' => $adm
        ]);
    }

    // Logout do administrador
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout realizado com sucesso.'
        ]);
    }

    // Recuperação de senha (exemplo simples: redefinir para CPF)
    public function recuperarSenha(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $adm = Adm::where('email', $request->email)->first();

        if (!$adm) {
            return response()->json([
                'status' => false,
                'message' => 'Email inválido.'
            ], 404);
        }

        // Redefinindo senha para CPF (ou você pode enviar email)
        $adm->password = Hash::make($adm->cpf);
        $adm->save();

        return response()->json([
            'status' => true,
            'message' => 'Senha redefinida com sucesso.',
        ]);
    }
}
