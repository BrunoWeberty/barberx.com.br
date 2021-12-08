@extends("layouts.relatorio")
@section("conteudo")
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<div class="container">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Gráfico de vendas</strong>
            </div> 
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3">Vendas durante o ano: {{$ano}}</h4>
                                <canvas id="lineChart" style="width:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        new Chart("lineChart", {
            type: 'line',
            data: {
                labels: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
                datasets: [
                    {
                        label: "Vendas",
                        borderColor: "rgba(0, 123, 255, 0.9)",
                        borderWidth: "1",
                        backgroundColor: "rgba(0, 123, 255, 0.5)",
                        pointHighlightStroke: "rgba(26,179,148,1)",
                        data: [ 
                            {{ $grafico[0] }}, 
                            {{ $grafico[1] }}, 
                            {{ $grafico[2] }}, 
                            {{ $grafico[3] }}, 
                            {{ $grafico[4] }}, 
                            {{ $grafico[5] }}, 
                            {{ $grafico[6] }},
                            {{ $grafico[7] }},
                            {{ $grafico[8] }},
                            {{ $grafico[9] }},
                            {{ $grafico[10] }},
                            {{ $grafico[11] }}
                        ]
                    }
                ]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }
            }
        });
    });
</script>
@stop