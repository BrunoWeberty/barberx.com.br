@extends("layouts.relatorio")
@section("conteudo")
<div class="container">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Relatório Financeiro</strong>
            </div> 
            <div class="card-body">
                <div class="row">
                    @if (count($vendas) == 0)
                    <div class="text-center mx-auto">
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            <span class="badge badge-pill badge-danger">Atenção</span>
                            Não foram encontrados registros na pesquisa realizada!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-12">
                        <div id="" class="margin_top margin_bottom table-responsive">
                            <table id="relatorio" class="table dt-responsive display nowrap w-100 border_bt_tb" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Data</th>
                                        <th>Promoção</th>
                                        <th>Tipo Pag.</th>
                                        <th>Observações</th>
                                    </tr>
                                </thead> 
                                <tbody> 
                                    @foreach($vendas as $row)
                                    <tr>
                                        <td>{{ $row->cliente }}</td>
                                        <td>R$ {{ number_format($row->total,2,",",".") }}</td>
                                        <td>{{date("d/m/Y", strtotime($row->created_at))}}</td>
                                        <td>{{ $row->promocao }}</td>
                                        <td>
                                            @if($row->obs == '1')
                                            Dinheiro
                                            @elseif($row->obs == '2')
                                            Cartão
                                            @else
                                            Pix
                                            @endif
                                        </td>
                                        <td>{{ $row->obs }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#relatorio').DataTable( {
            dom: 'Bfrtip',
            // "scrollX": false,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ Resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
                paginate: { 
                    previous: "<i class='mdi mdi-chevron-left'>", 
                    next: "<i class='mdi mdi-chevron-right'>" 
                } 
            }
        });
    });
</script>
@stop