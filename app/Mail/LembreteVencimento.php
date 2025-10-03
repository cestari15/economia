<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LembreteVencimento extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;

    public function __construct($evento)
    {
        $this->evento = $evento;
    }

    public function build()
    {
        return $this->subject('Lembrete de Vencimento')
            ->view('emails.lembrete');
    }
}
