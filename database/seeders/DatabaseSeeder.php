<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adm;
use App\Models\Cliente; // Adicionado
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =======================
        // Seed do admin
        // =======================
        $emailAdmin = 'cestari1502@gmail.com';

        $admExistente = Adm::where('email', $emailAdmin)->first();

        if (!$admExistente) {
            Adm::create([
                'name' => 'Rafael Cestari',
                'email' => $emailAdmin,
                'cpf' => '47252364895',
                'password' => Hash::make('123456'), // senha desejada
                'tipo' => 'admin',
            ]);

            $this->command->info('Admin Rafael criado com sucesso!');
        } else {
            $this->command->info('Admin Rafael já existe, nada foi feito.');
        }

        // =======================
        // Seed de clientes
        // =======================
        $clientes = [
            [
                'nome' => 'Rafael Cestari',
                'cpf' => '12345678901',
                'email' => 'rafael@example.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'nome' => 'Maria Silva',
                'cpf' => '98765432100',
                'email' => 'maria@example.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'nome' => 'João Pereira',
                'cpf' => '11122233344',
                'email' => 'joao@example.com',
                'password' => Hash::make('senha123'),
            ],
        ];

        foreach ($clientes as $cliente) {
            // Evita duplicação
            if (!Cliente::where('email', $cliente['email'])->exists()) {
                Cliente::create($cliente);
                $this->command->info("Cliente {$cliente['nome']} criado com sucesso!");
            } else {
                $this->command->info("Cliente {$cliente['nome']} já existe, nada foi feito.");
            }
        }
    }
}
