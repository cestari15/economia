<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anotacoes;
use Carbon\Carbon;

class RelatoriosController extends Controller
{
    // 1. Total geral de todas as anotações
    public function totalGeral()
    {
        $total = Anotacoes::sum('valor');

        return response()->json([
            'status' => true,
            'total_geral' => $total
        ]);
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
}
