<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AnotacoesController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\RelatoriosController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::post('clientes/store', [ClienteController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('adm/login', [AdmController::class, 'login']);

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (SANCTUM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Usuário autenticado
    Route::get('/user', fn () => request()->user());

    // Logout
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('adm/logout', [AdmController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | EVENTOS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ANOTAÇÕES
    |--------------------------------------------------------------------------
    */
    Route::get('anotacoes', [AnotacoesController::class, 'retornarTodos']);
    Route::post('anotacoes/store', [AnotacoesController::class, 'store']);
    Route::put('anotacoes', [AnotacoesController::class, 'editar']);
    Route::delete('anotacoes/{id}', [AnotacoesController::class, 'delete']);

    /*
    |--------------------------------------------------------------------------
    | RELATÓRIOS (🔥 COMPLETO 🔥)
    |--------------------------------------------------------------------------
    */

    // Total geral
    Route::get('relatorios/total-geral', [RelatoriosController::class, 'totalGeral']);

    // Total por categoria (geral)
    Route::get('relatorios/por-categoria', [RelatoriosController::class, 'totalPorCategoria']);

    // Total por mês
    Route::get('relatorios/por-mes/{ano}/{mes}', [RelatoriosController::class, 'totalPorMes']);

    // Resumo mensal (total + categorias)
    Route::get('relatorios/resumo', [RelatoriosController::class, 'resumoGeral']);

    // Total por dia do mês
    Route::get('relatorios/por-dia/{ano}/{mes}', [RelatoriosController::class, 'totalPorDiaMes']);

    // 🔥 Gastos por categoria no mês (select de mês)
    Route::get('relatorios/categoria-por-mes/{ano}/{mes}', [RelatoriosController::class, 'categoriaPorMes']);

    // 🔥 Resumo anual (12 meses)
    Route::get('relatorios/anual/{ano}', [RelatoriosController::class, 'resumoAnual']);

    /*
    |--------------------------------------------------------------------------
    | CLIENTES (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {
        Route::get('clientes', [ClienteController::class, 'retornarTodos']);
        Route::put('clientes', [ClienteController::class, 'editar']);
        Route::delete('clientes/{id}', [ClienteController::class, 'delete']);
        Route::get('clientes/listar', [ClienteController::class, 'listarClientes']);
    });
});




Route::middleware('auth:cliente')->group(function () {

    Route::get('/calendario', [CalendarioController::class, 'listar']);

    Route::post('/calendario', [CalendarioController::class, 'store']);

    Route::delete('/calendario/{id}', [CalendarioController::class, 'destroy']);

});

