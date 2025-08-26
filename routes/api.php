<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AnotacoesController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\AuthController;

// ============================
// Rotas de Clientes
// ============================
Route::post('/clientes/store', [ClienteController::class, 'store']);         
Route::put('/clientes', [ClienteController::class, 'editar']);        
Route::delete('/clientes/{id}', [ClienteController::class, 'delete']); 
Route::get('/clientes', [ClienteController::class, 'retornarTodos']);  
Route::get('/clientes/{id}', [ClienteController::class, 'pesquisarPorId']); 
Route::get('/clientes/pesquisa', [ClienteController::class, 'pesquisar']); 
Route::post('/recuperar-senha', [ClienteController::class, 'recuperarSenha']);


// ============================
// Rotas de Anotações
// ============================
Route::post('/anotacoes/store', [AnotacoesController::class, 'store']);       
Route::put('/anotacoes', [AnotacoesController::class, 'editar']);      
Route::delete('/anotacoes/{id}', [AnotacoesController::class, 'delete']);
Route::get('/anotacoes', [AnotacoesController::class, 'retornarTodos']);
Route::get('/anotacoes/{id}', [AnotacoesController::class, 'pesquisarPorId']);
Route::get('/anotacoes/pesquisa', [AnotacoesController::class, 'pesquisar']);

// ============================
// Rotas de Relatórios
// ============================
Route::get('/relatorios/total-geral', [RelatoriosController::class, 'totalGeral']);
Route::get('/relatorios/por-categoria', [RelatoriosController::class, 'totalPorCategoria']);
Route::get('/relatorios/por-mes/{ano}/{mes}', [RelatoriosController::class, 'totalPorMes']);
Route::get('/relatorios/resumo', [RelatoriosController::class, 'resumoGeral']);


// ============================
// Rotas de Login
// ============================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

