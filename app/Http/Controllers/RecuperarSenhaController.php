<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
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
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $link = url('/nova-senha/' . $token . '?email=' . urlencode($request->email));

        // 🔥 TEMPORÁRIO PARA TESTE (sem configurar email ainda)
        return response()->json([
            'status' => true,
            'message' => 'Link gerado com sucesso.',
            'debug_link' => $link
        ]);

        /*
        // 🚀 QUANDO CONFIGURAR EMAIL, USE ISSO:

        Mail::raw("Clique para redefinir sua senha: $link", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Redefinição de senha - ECONOMIZZ');
        });

        return response()->json([
            'status' => true,
            'message' => 'Link enviado para seu e-mail.'
        ]);
        */
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$reset) {
            return response()->json([
                'status' => false,
                'message' => 'Token inválido.'
            ]);
        }

        if (!Hash::check($request->token, $reset->token)) {
            return response()->json([
                'status' => false,
                'message' => 'Token inválido ou expirado.'
            ]);
        }

        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'Token expirado.'
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Senha redefinida com sucesso.'
        ]);
    }
}