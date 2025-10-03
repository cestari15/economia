@extends('template')

@section('titulo', 'Home')

@section('conteudo')
<div class="container-fluid mt-3">

    <!-- Cards de resumo -->
    <div class="row row-group m-0">
        <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body bg-primary text-white rounded">
                <h5>Total Geral</h5>
                <h3 id="total-geral">R$ 0</h3>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body bg-success text-white rounded">
                <h5>Total por Categoria</h5>
                <div id="chart-categoria"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3 border-light">
            <div class="card-body bg-warning text-white rounded">
                <h5>Total por Mês</h5>
                <div id="chart-mes"></div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const token = localStorage.getItem('token');
    if (!token) return alert('Você precisa estar logado');

    try {
        // 1️⃣ Total geral
        const resTotal = await fetch('{{ url("/api/relatorios/total-geral") }}', {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const dataTotal = await resTotal.json();
        if(dataTotal.status) {
            document.getElementById('total-geral').innerText = `R$ ${dataTotal.total_geral.toFixed(2)}`;
        }

        // 2️⃣ Total por categoria
        const resCat = await fetch('{{ url("/api/relatorios/por-categoria") }}', {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const dataCat = await resCat.json();
        if(dataCat.status) {
            const options = {
                chart: { type: 'donut', height: 300 },
                series: dataCat.totais_por_categoria.map(c => c.total),
                labels: dataCat.totais_por_categoria.map(c => c.categoria)
            };
            const chart = new ApexCharts(document.querySelector("#chart-categoria"), options);
            chart.render();
        }

        // 3️⃣ Total por mês (mês atual)
        const now = new Date();
        const ano = now.getFullYear();
        const mes = now.getMonth() + 1;
        const resMes = await fetch(`/api/relatorios/por-mes/${ano}/${mes}`, {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const dataMes = await resMes.json();
        if(dataMes.status) {
            const options = {
                chart: { type: 'bar', height: 300 },
                series: [{ name: 'Total', data: [dataMes.total] }],
                xaxis: { categories: [`${mes}/${ano}`] }
            };
            const chartMes = new ApexCharts(document.querySelector("#chart-mes"), options);
            chartMes.render();
        }

    } catch(err) {
        console.log(err);
    }
});
</script>
@endsection
