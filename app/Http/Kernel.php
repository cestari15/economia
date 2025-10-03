<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Evento;
use App\Mail\LembreteVencimento;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Defina os comandos Artisan disponíveis.
     */
    protected $commands = [
        // Registre comandos Artisan aqui se necessário
    ];

    /**
     * Defina os agendamentos de tarefas.
     */
    protected function schedule(Schedule $schedule)
    {
        // Agendamento diário para enviar lembretes de eventos
        $schedule->call(function () {
            $hoje = Carbon::today();

            // Busca apenas eventos que precisam de lembrete
            $eventos = Evento::whereNotNull('dias_antes')
                              ->whereDate('data', '>=', $hoje)
                              ->get();

            foreach ($eventos as $evento) {
                // Calcula a data de envio do lembrete
                $dataLembrete = Carbon::parse($evento->data)->subDays((int)$evento->dias_antes);

                // Envia e-mail apenas se o lembrete é hoje
                if ($dataLembrete->isSameDay($hoje)) {
                    try {
                        Mail::to($evento->email)->send(new LembreteVencimento($evento));
                        Log::info("Lembrete enviado para {$evento->email} referente ao evento ID {$evento->id}");
                    } catch (\Exception $e) {
                        Log::error("Erro ao enviar e-mail para {$evento->email} (Evento ID {$evento->id}): {$e->getMessage()}");
                    }
                }
            }
        })->dailyAt('08:00'); // Executa diariamente às 08:00 da manhã
    }

    /**
     * Registre os comandos Artisan.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
