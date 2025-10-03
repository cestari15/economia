<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AnotacoesController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\RelatoriosController;

// Rotas públicas
Route::post('clientes/store', [ClienteController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);          // login cliente
Route::post('register', [AuthController::class, 'register']);    // registro cliente
Route::post('adm/login', [AdmController::class, 'login']);       // login admin

// Rotas protegidas por Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Usuário logado
    Route::get('/user', fn() => request()->user());

    // Logout
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('adm/logout', [AdmController::class, 'logout']);


    // Rotas protegidas por Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('eventos', [EventoController::class, 'index']);
        Route::post('eventos', [EventoController::class, 'store']);
        Route::delete('eventos/{id}', [EventoController::class, 'destroy']);
    });

    // Anotações
    Route::get('anotacoes', [AnotacoesController::class, 'retornarTodos']);
    Route::post('anotacoes/store', [AnotacoesController::class, 'store']);
    Route::put('anotacoes', [AnotacoesController::class, 'editar']);
    Route::delete('anotacoes/{id}', [AnotacoesController::class, 'delete']);

    // Clientes (somente admin)
    Route::middleware('admin')->group(function () {
        Route::get('clientes', [ClienteController::class, 'retornarTodos']);
        Route::put('clientes', [ClienteController::class, 'editar']);
        Route::delete('clientes/{id}', [ClienteController::class, 'delete']);
    });

    // Relatórios
    Route::get('relatorios/total-geral', [RelatoriosController::class, 'totalGeral']);
    Route::get('relatorios/por-categoria', [RelatoriosController::class, 'totalPorCategoria']);
    Route::get('relatorios/por-mes/{ano}/{mes}', [RelatoriosController::class, 'totalPorMes']);
    Route::get('relatorios/resumo', [RelatoriosController::class, 'resumoGeral']);

    // Eventos separados
    Route::get('eventos-list', [EventoController::class, 'index']);
    Route::post('eventos-list', [EventoController::class, 'store']);


    // LISTAGEM
    Route::middleware(['auth:sanctum', 'admin'])->get('clientes/listar', [ClienteController::class, 'listarClientes']);
});
