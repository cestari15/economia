<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        // Clientes de teste
        $clientes = [
            [
                'nome' => 'Rafael Cestari',
                'cpf' => '12345678901',
                'email' => 'rafael@gmail.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'nome' => 'Maria Silva',
                'cpf' => '98765432100',
                'email' => 'maria@gmail.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'nome' => 'João Pereira',
                'cpf' => '11122233344',
                'email' => 'joao@gmail.com',
                'password' => Hash::make('senha123'),
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
