<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120)->nullable(false);
            $table->string('email', 120)->unique()->nullable(false);
            $table->string('cpf', 11)->unique()->nullable(false);
            $table->string('password')->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adms');
    }
};
