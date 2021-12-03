@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.modal-excluir')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Listagem de Promoção</strong>
            @if(Auth::user()->tipo <> 'c')
                <a href="promocao/">
                    <div class="box_right pointer" >
                        <span class="btn-info pointer">Nova Promoção</span> 
                    </div>
                </a>
            @endif
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Promoção</th>
                            <th>Porcentagem de desconto</th>
                            @if(Auth::user()->tipo <> 'c')
                                <th>Ativo</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promocao as $row)
                        @if ($row->ativo == 'a')
                            <tr class="sucess_tb" > 
                        @else         
                            <tr class="warning_tb" >
                        @endif
                            <td>{{ $row->descricao }}</td>
                            <td>{{ $row->porcentagem }}%</td>
                            @if(Auth::user()->tipo <> 'c')
                                @if ($row->ativo == 'a')
                                <td><span class="badge badge-success">Ativo</span></td>
                                @else        
                                <td><span class="badge badge-warning">Inativo</span></td>
                                @endif
                                <td>
                                    <a href="promocao/{{$row->idPromocao }}">
                                        <div class="btn btn-sm btn-outline-primary">
                                            <i class="fa-pencil-square-o fa"></i>
                                            Editar
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <button  onclick="abreModalExcluir('promocao/excluir/{{ $row->idPromocao }}');" data-toggle="modal" data-target="#modalExcluir" type="button" class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-times-circle-o"></i>
                                        Excluir
                                    </button>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    @if(Auth::user()->tipo == 'c')
                    <p>Obs.: A promoção listada acima, será aplicado automaticamente o desconto no momento do pagamento.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop