<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adm;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Email do admin que deseja criar
        $emailAdmin = 'cestari1502@gmail.com';

        // Verifica se o admin já existe
        $admExistente = Adm::where('email', $emailAdmin)->first();

        if (!$admExistente) {
            Adm::create([
                'name' => 'Rafael Cestari',
                'email' => $emailAdmin,
                'cpf' => '47252364895',
                'password' => Hash::make('123456'), // senha desejada
                'tipo' => 'admin', // muito importante para o middleware
            ]);

            $this->command->info('Admin Rafael criado com sucesso!');
        } else {
            $this->command->info('Admin Rafael já existe, nada foi feito.');
        }
    }
}
