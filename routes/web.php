<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarioController;

// Páginas públicas
Route::view('/', 'home')->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/registro', 'registro')->name('register');
Route::view('/esqueci-senha', 'esqueci-senha')->name('esqueci-senha');
Route::view('/profile', 'profile')->name('profile');
Route::view('/anotacoes', 'anotacoes')->name('anotacoes');
Route::view('/calendario', 'calendario')->name('calendario');

// Página da listagem de clientes (somente admin)
Route::view('/listagem-clientes', 'listagemClientes')
    ->name('listagem-clientes')
    ->middleware(['auth:sanctum', 'admin']);
