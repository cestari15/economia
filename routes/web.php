<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecuperarSenhaController;
use App\Http\Controllers\CalendarioController;

// Páginas públicas
Route::view('/relatorios', 'relatorios')->name('relatorios');
Route::view('/', 'home')->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/registro', 'registro')->name('register');

Route::view('/profile', 'profile')->name('profile');
Route::view('/anotacoes', 'anotacoes')->name('anotacoes');
Route::view('/calendario', 'calendario')->name('calendario');
Route::view('/configuracoes','configuracoes')->name('configuracoes');


// Página da listagem de clientes (somente admin)
Route::view('/listagem-clientes', 'listagemClientes')
    ->name('listagem-clientes')
    ->middleware(['auth:sanctum', 'admin']);



Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::get('/servicos', function () {
    return view('servicos'); // Isso vai procurar o arquivo resources/views/servicos.blade.php
})->name('servicos');





// routes/web.php
Route::get('/clientes', function () {
    return view('listagemClientes'); 
});


// RECUPERAR SENHA
Route::get('/recuperar-senha', [RecuperarSenhaController::class, 'formEmail'])
    ->name('recuperar-senha.form');

Route::post('/recuperar-senha', [RecuperarSenhaController::class, 'enviar'])
    ->name('recuperar-senha');

Route::get('/nova-senha/{token}', [RecuperarSenhaController::class, 'formNovaSenha'])
    ->name('nova-senha.form');

Route::post('/nova-senha', [RecuperarSenhaController::class, 'resetarSenha'])
    ->name('nova-senha');