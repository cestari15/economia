<?php

namespace App\Http\Controllers;

use App\Models\Anotacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatoriosController extends Controller
{
    /* ===============================
       1. TOTAL GERAL
    ================================ */
    public function totalGeral(Request $request)
    {
        $user = $request->user();

        $total = Anotacoes::where('cliente_id', $user->id)
            ->sum('valor');

        return response()->json([
            'status' => true,
            'total_geral' => $total
        ]);
    }

    /* ===============================
       2. TOTAL POR CATEGORIA (GERAL)
    ================================ */
    public function totalPorCategoria(Request $request)
    {
        $user = $request->user();

        $dados = Anotacoes::where('cliente_id', $user->id)
            ->select('categoria')
            ->selectRaw('SUM(valor) as total')
            ->groupBy('categoria')
            ->get();

        return response()->json([
            'status' => true,
            'totais_por_categoria' => $dados
        ]);
    }

    /* ===============================
       3. TOTAL POR MÊS
    ================================ */
    public function totalPorMes(Request $request, $ano, $mes)
    {
        $user = $request->user();

        $total = Anotacoes::where('cliente_id', $user->id)
            ->whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->sum('valor');

        return response()->json([
            'status' => true,
            'ano' => $ano,
            'mes' => $mes,
            'total' => $total
        ]);
    }

    /* ===============================
       4. RESUMO GERAL (MÊS + CATEGORIA)
    ================================ */
    public function resumoGeral(Request $request)
    {
        $user = $request->user();
        $ano = $request->input('ano', Carbon::now()->year);
        $mes = $request->input('mes', Carbon::now()->month);

        $totalMes = Anotacoes::where('cliente_id', $user->id)
            ->whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->sum('valor');

        $porCategoria = Anotacoes::where('cliente_id', $user->id)
            ->whereYear('data', $ano)
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

    /* ===============================
       5. TOTAL POR DIA DO MÊS
    ================================ */
    public function totalPorDiaMes(Request $request, $ano, $mes)
    {
        $user = $request->user();

        $dados = Anotacoes::where('cliente_id', $user->id)
            ->select(
                DB::raw('DAY(data) as dia'),
                DB::raw('SUM(valor) as total')
            )
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

    /* ===============================
       6. GASTOS POR CATEGORIA (MENSAL)
       🔥 USADO NO SELECT DE MÊS
    ================================ */
    public function categoriaPorMes(Request $request, $ano, $mes)
    {
        $user = $request->user();

        $dados = Anotacoes::where('cliente_id', $user->id)
            ->whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->select('categoria')
            ->selectRaw('SUM(valor) as total')
            ->groupBy('categoria')
            ->get();

        return response()->json([
            'status' => true,
            'ano' => $ano,
            'mes' => $mes,
            'totais' => $dados
        ]);
    }

    /* ===============================
       7. RESUMO ANUAL (12 MESES)
       🔥 GRÁFICO DE LINHA
    ================================ */
    public function resumoAnual(Request $request, $ano)
    {
        $user = $request->user();

        $dados = Anotacoes::where('cliente_id', $user->id)
            ->whereYear('data', $ano)
            ->select(
                DB::raw('MONTH(data) as mes'),
                DB::raw('SUM(valor) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Monta array fixo de 12 meses
        $meses = collect(range(1, 12))->map(function ($mes) use ($dados) {
            $registro = $dados->firstWhere('mes', $mes);

            return [
                'mes' => Carbon::create()->month($mes)->translatedFormat('M'),
                'total' => $registro ? $registro->total : 0
            ];
        });

        return response()->json([
            'status' => true,
            'ano' => $ano,
            'meses' => $meses
        ]);
    }
}
