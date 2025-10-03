<?php

namespace App\Http\Controllers;

use App\Models\Anotacao;
use App\Models\Anotacaoes;
use Illuminate\Http\Request;
use App\Models\Anotacoes;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatoriosController extends Controller
{
    // 1. Total geral de todas as anotações
    public function totalGeral()
    {
        try {
            // Exemplo: total de clientes
            $totalClientes = Cliente::count();

            // Se tiver outros modelos, ex:
            // $totalEventos = Evento::count();

            return response()->json([
                'status' => true,
                'data' => [
                    'total_clientes' => $totalClientes,
                    // 'total_eventos' => $totalEventos,
                ]
            ]);
        } catch (\Exception $e) {
            // Retorna erro detalhado sem quebrar a rota
            return response()->json([
                'status' => false,
                'message' => 'Erro ao gerar relatório: ' . $e->getMessage()
            ], 500);
        }
    }

    // 2. Total por categoria
    public function totalPorCategoria()
    {
        $dados = Anotacoes::select('categoria')
            ->selectRaw('SUM(valor) as total')
            ->groupBy('categoria')
            ->get();

        return response()->json([
            'status' => true,
            'totais_por_categoria' => $dados
        ]);
    }

    // 3. Total por mês/ano
    public function totalPorMes($ano, $mes)
    {
        $total = Anotacoes::whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->sum('valor');

        return response()->json([
            'status' => true,
            'ano' => $ano,
            'mes' => $mes,
            'total' => $total
        ]);
    }

    // 4. Resumo geral (total + categorias do mês)
    public function resumoGeral(Request $request)
    {
        $ano = $request->input('ano', Carbon::now()->year);
        $mes = $request->input('mes', Carbon::now()->month);

        $totalMes = Anotacoes::whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->sum('valor');

        $porCategoria = Anotacoes::whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->select('categoria')
            ->selectRaw('SUM(valor) as total')
            ->groupBy('categoria')
            ->get();

        return response()->json([
            'status' => true,
            'ano' => $ano,
            'mes' => $mes,
            'total_mes' => $totalMes,
            'totais_por_categoria' => $porCategoria
        ]);
    }

    public function totalPorDiaMes($ano, $mes)
    {
        $dados = Anotacoes::select(DB::raw('DAY(data) as dia'), DB::raw('SUM(valor) as total'))
            ->whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return response()->json([
            'status' => true,
            'ano' => $ano,
            'mes' => $mes,
            'totais_por_dia' => $dados
        ]);
    }
}
