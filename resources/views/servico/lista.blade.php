@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.modal-excluir')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Listagem de Serviços</strong>
            <a href="servico/">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Novo Serviço</span> 
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Nome do Serviço</th>
                            <th>Preço</th>
                            <th>Ativo</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servico as $row)
                        @if ($row->ativo == 'a')
                            <tr class="sucess_tb" >
                        @else        
                            <tr class="warning_tb" >
                        @endif
                            <td>{{ $row->descricao }}</td>
                            <td>R$ {{ number_format($row->valor,2,",",".") }}</td>
                            @if ($row->ativo == 'a')
                            <td><span class="badge badge-success">Ativo</span></td>
                            @else        
                            <td><span class="badge badge-warning">Inativo</span></td>
                            @endif
                            <td>
                                <a href="servico/{{$row->idServico }}">
                                    <div class="btn btn-sm btn-outline-primary">
                                        <i class="fa-pencil-square-o fa"></i>
                                        Editar
                                    </div>
                                </a>
                            </td>
                            <td>
                                <button  onclick="abreModalExcluir('servico/excluir/{{ $row->idServico }}');" data-toggle="modal" data-target="#modalExcluir" type="button" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-times-circle-o"></i>
                                    Excluir
                                </button>
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