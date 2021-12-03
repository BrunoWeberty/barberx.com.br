@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.modal-excluir')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Listagem de Marcas</strong>
            <a href="marca/">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Nova Marca</span> 
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Nome da Marca</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($marca as $row)
                        <tr>
                            <td>{{ $row->descricao }}</td>
                            <td>
                                <a href="marca/{{$row->idMarca }}">
                                    <div class="btn btn-sm btn-outline-primary">
                                        <i class="fa-pencil-square-o fa"></i>
                                        Editar
                                    </div>
                                </a>
                            </td>
                            <td>
                                <button  onclick="abreModalExcluir('marca/excluir/{{ $row->idMarca }}');" data-toggle="modal" data-target="#modalExcluir" type="button" class="btn btn-sm btn-outline-danger">
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