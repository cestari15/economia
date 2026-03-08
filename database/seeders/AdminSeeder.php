<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $emailAdmin = 'cestari1502@gmail.com';
        $admin = Cliente::where('email', $emailAdmin)->first();

        if (!$admin) {
            Cliente::create([
                'nome' => 'Rafael Cestari',
                'email' => $emailAdmin,
                'cpf' => '47252364895',
                'password' => Hash::make('123456'),
                'tipo' => 'admin',
                'status_pagamento' => 'em_dia'
            ]);
            $this->command->info('Admin Rafael criado com sucesso!');
        } else {
            $this->command->info('Admin já existe.');
        }
    }
}
