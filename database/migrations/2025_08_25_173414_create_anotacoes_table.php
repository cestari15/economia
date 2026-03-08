<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anotacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // primeiro criamos a coluna
            $table->string('nome', 100);
            $table->string('categoria', 100);
            $table->decimal('valor', 10, 2);
            $table->date('data');
            $table->timestamps();

            // depois criamos a foreign key
            $table->foreign('cliente_id')
                  ->references('id')
                  ->on('clientes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anotacoes');
    }
};
