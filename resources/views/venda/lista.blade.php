@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.modal-excluir')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Listagem de Vendas</strong>
            <a href="venda/">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Novo Venda</span> 
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Total</th>
                            <th>Tipo Pag.</th>
                            <th>Observações</th>
                            <th>Status</th>
                            <th>Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($venda as $row)
                        @if ($row->status == 'f')
                            <tr class="sucess_tb" >
                        @else        
                            <tr class="warning_tb" >
                        @endif
                            <td>{{ $row->cliente }}</td>
                            <td><?= date("d/m/Y H:i", strtotime($row->created_at)) ?></td>
                            <td>R$ {{ number_format($row->total,2,",",".") }}</td>
                            <td>
                                @if($row->tipoPagamento == '1')
                                Dinheiro
                                @elseif($row->tipoPagamento == '2')
                                Cartão
                                @elseif($row->tipoPagamento == '3')
                                Pix
                                @endif
                            </td>
                            <td>
                                {{ htmlspecialchars($row->obs) }}
                            </td>
                            @if ($row->status == 'f')
                            <td><span class="badge badge-success">Realizada</span></td>
                            @else        
                            <td><span class="badge badge-warning">Incompleta</span></td>
                            @endif
                            <td>
                                <a href="venda/{{$row->idVenda }}">
                                    <div class="btn btn-sm btn-outline-primary">
                                        <i class=" fa-eye fa"></i>
                                        Visualizar
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop