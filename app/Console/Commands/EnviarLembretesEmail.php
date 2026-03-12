<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Calendario;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarLembretesEmail extends Command
{
    // O nome do comando que será usado no cronos
    protected $signature = 'lembretes:enviar';
    protected $description = 'Verifica e envia e-mails de lembrete baseados no dia configurado';

    public function handle()
    {
        $hoje = \Carbon\Carbon::now();
        $diaAtual = $hoje->day;

        $eventos = \App\Models\Calendario::where('dias_lembrete', $diaAtual)->get();

        foreach ($eventos as $evento) {
            $cliente = $evento->cliente;

            if ($cliente && $cliente->email) {
                $dados = [
                    'nome' => $cliente->nome,
                    'tituloEvento' => $evento->title,
                    'dataEvento' => \Carbon\Carbon::parse($evento->data_evento)->format('d/m/Y')
                ];

                \Illuminate\Support\Facades\Mail::send('emails.lembrete', $dados, function ($message) use ($cliente) {
                    $message->to($cliente->email)
                        ->subject('🔔 Lembrete de Compromisso - CRONOS');
                });
            }
        }

        $this->info('Lembretes visuais enviados com sucesso!');
    }
}
