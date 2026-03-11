<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AnotacoesController;
use App\Http\Controllers\RelatoriosController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS (Acesso sem Login)
|--------------------------------------------------------------------------
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('clientes/store', [ClienteController::class, 'store']);
Route::post('adm/login', [AdmController::class, 'login']);

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (Necessário Token Bearer)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

   // Dados da conta (os campos que você carregou no front-end)
    Route::get('/cliente/dados', [ClienteController::class, 'getDadosConta']);
    
    // Atualizar perfil
    Route::put('/cliente', [ClienteController::class, 'updatePerfil']);
    
    // Atualizar senha
    Route::put('/cliente/senha', [ClienteController::class, 'updateSenha']);
    
    // Deletar conta
    Route::delete('/cliente', [ClienteController::class, 'destroyMinhaConta']);

    // Dados do Usuário Logado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('adm/logout', [AdmController::class, 'logout']);

    /* --- CALENDÁRIO --- */
    Route::get('/calendario', [CalendarioController::class, 'listar']);
    Route::post('/calendario', [CalendarioController::class, 'store']);
    Route::delete('/calendario/{id}', [CalendarioController::class, 'destroy']);

    /* --- ANOTAÇÕES --- */
    Route::get('anotacoes', [AnotacoesController::class, 'retornarTodos']);
    Route::post('anotacoes/store', [AnotacoesController::class, 'store']);
    Route::put('anotacoes', [AnotacoesController::class, 'editar']);
    Route::delete('anotacoes/{id}', [AnotacoesController::class, 'delete']);

    /* --- RELATÓRIOS --- */
    Route::get('relatorios/total-geral', [RelatoriosController::class, 'totalGeral']);
    Route::get('relatorios/por-categoria', [RelatoriosController::class, 'totalPorCategoria']);
    Route::get('relatorios/por-mes/{ano}/{mes}', [RelatoriosController::class, 'totalPorMes']);
    Route::get('relatorios/resumo', [RelatoriosController::class, 'resumoGeral']);
    Route::get('relatorios/por-dia/{ano}/{mes}', [RelatoriosController::class, 'totalPorDiaMes']);
    Route::get('relatorios/categoria-por-mes/{ano}/{mes}', [RelatoriosController::class, 'categoriaPorMes']);
    Route::get('relatorios/anual/{ano}', [RelatoriosController::class, 'resumoAnual']);

    /*
    |--------------------------------------------------------------------------
    | ÁREA DO ADMINISTRADOR (Middleware Extra)
    |--------------------------------------------------------------------------
    */
    
    Route::middleware('admin')->group(function () {
        Route::get('/clientes', [ClienteController::class, 'retornarTodos']);
        Route::get('clientes/listar', [ClienteController::class, 'listarClientes']);
        Route::put('clientes', [ClienteController::class, 'editar']);
        Route::delete('clientes/{id}', [ClienteController::class, 'delete']);
    });
});
