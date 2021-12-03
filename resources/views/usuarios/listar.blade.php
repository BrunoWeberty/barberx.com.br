
@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.modal-excluir')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Listagem de Usuarios</strong>
            <a href="usuario/">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Novo</span> 
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Login</th>
                            <th>Tipo</th>
                            <th>Ativo</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        @if ($usuario->status == 'a')
                            <tr class="sucess_tb" >
                        @else        
                            <tr class="warning_tb" >
                        @endif
                            <td>{{$usuario->nome}}</td>
                            <td>{{$usuario->login}}</td>
                            <td>
                                <?php 
                                    if ($usuario->tipo == 'g'){
                                        echo 'Administrador';
                                    }if ($usuario->tipo == 'f'){
                                        echo 'Funcionário';
                                    }if ($usuario->tipo == 'c'){
                                        echo 'Cliente';
                                    }
                                ?>
                            </td>
                            @if ($usuario->status == 'a')
                            <td><span class="badge badge-success">Ativo</span></td>
                            @else        
                            <td><span class="badge badge-warning">Inativo</span></td>
                            @endif
                            <td>
                                <a href="usuario/{{$usuario->id}}">
                                    <div class="btn btn-sm btn-outline-primary">
                                        <i class="fa-pencil-square-o fa"></i>
                                        Editar
                                    </div>
                                </a>
                            </td>
                            <td>
                                <button  onclick="abreModalExcluir('usuario/excluir/{{ $usuario->id }}');" data-toggle="modal" data-target="#modalExcluir" type="button" class="btn btn-sm btn-outline-danger">
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
