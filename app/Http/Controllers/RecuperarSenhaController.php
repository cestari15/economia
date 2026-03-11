<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Cliente;
use Carbon\Carbon;

class RecuperarSenhaController extends Controller
{
    // ================================
    // 1️⃣ Mostrar formulário de email
    // ================================
    public function formEmail()
    {
        return view('esqueciSenha');
    }

    // ================================
    // 2️⃣ Gerar token e enviar link
    // ================================
    public function enviar(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = Cliente::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => true, 'message' => 'Se este e-mail estiver cadastrado, você receberá um link de redefinição em breve.']);
        }

        $token = Str::random(64);
        $link = url('/nova-senha/' . $token . '?email=' . urlencode($request->email));

        // TESTE DE FORÇAR ENVIO E PEGAR O ERRO
        try {
            \Log::info('Tentando disparar Mail::send para ' . $request->email);

            Mail::raw("Link de recuperação: $link", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Teste de Envio CRONOS');
            });

            \Log::info('Mail::raw executado com sucesso.');
            return response()->json(['status' => true, 'message' => 'E-mail enviado!']);
        } catch (\Exception $e) {
            \Log::error('ERRO CRÍTICO NO ENVIO: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ================================
    // 3️⃣ Mostrar formulário nova senha
    // ================================
    public function formNovaSenha(Request $request, $token)
    {
        return view('novaSenha', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // ================================
    // 4️⃣ Resetar senha
    // ================================
    public function resetarSenha(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email', // Remova o 'exists:users,email' se a tabela não for 'users'
            'password' => 'required|min:6|confirmed'
        ]);

        // Busca na tabela correta
        $user = \App\Models\Cliente::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Usuário não encontrado.']);
        }

        // ... restante da lógica de validar o token e salvar a nova senha
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => true, 'message' => 'Senha redefinida com sucesso.']);
    }
}
