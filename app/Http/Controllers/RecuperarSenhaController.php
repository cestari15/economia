<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        // Validação básica do campo
        $request->validate(['email' => 'required|email']);
        
        // Busca o cliente na tabela 'clientes'
        $user = Cliente::where('email', $request->email)->first();

        // Se o usuário não existir, retornamos sucesso por segurança (evita descoberta de e-mails)
        if (!$user) {
            return response()->json([
                'status' => true, 
                'message' => 'Se este e-mail estiver cadastrado, você receberá um link de redefinição em breve.'
            ]);
        }

        // Gera um token aleatório de 64 caracteres
        $token = Str::random(64);
        
        // Monta o link que será enviado dentro do botão no HTML
        $link = url('/nova-senha/' . $token . '?email=' . urlencode($request->email));

        try {
            // O caminho 'emails.reset-senha' aponta para: 
            // resources/views/emails/reset-senha.blade.php
            Mail::send('emails.reset-senha', ['link' => $link], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Redefinição de Senha - CRONOS');
            });

            return response()->json([
                'status' => true, 
                'message' => 'E-mail enviado com sucesso! Verifique sua caixa de entrada.'
            ]);

        } catch (\Exception $e) {
            // Caso ocorra erro no SMTP ou credenciais, salva no log do Laravel
            \Log::error('ERRO NO ENVIO DE E-MAIL: ' . $e->getMessage());
            
            return response()->json([
                'status' => false, 
                'message' => 'Erro ao enviar e-mail. Verifique suas configurações de SMTP.'
            ], 500);
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
    // 4️⃣ Resetar senha final
    // ================================
    public function resetarSenha(Request $request)
    {
        // Valida se a senha tem no mínimo 6 dígitos e se os dois campos são iguais (confirmed)
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Busca o cliente novamente para aplicar a nova senha
        $user = Cliente::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Usuário não encontrado.']);
        }

        // Encripta a nova senha e salva no banco
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => true, 
            'message' => 'Senha redefinida com sucesso! Você já pode fazer login.'
        ]);
    }
}