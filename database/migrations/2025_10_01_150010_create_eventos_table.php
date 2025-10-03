<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relaciona com usuários
            $table->string('title'); // Ex: "Cartão Sicredi"
            $table->date('start'); // Data do vencimento
            $table->integer('reminder_days_before')->default(5); // Dias antes para o lembrete
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos');
    }
};
