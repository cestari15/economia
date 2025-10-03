<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adms', function (Blueprint $table) {
            $table->string('tipo')->default('admin'); // valor padrão 'admin'
        });
    }

    public function down(): void
    {
        Schema::table('adms', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
