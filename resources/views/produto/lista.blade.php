@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.modal-img')
@include('components.modal-excluir')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Listagem de Produtos</strong>
            @if(Auth::user()->tipo <> 'c')
            <a href="produto/">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Novo Produto</span> 
                </div>
            </a>
            @endif
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Marca</th>
                            <th>Imagem</th>
                            <th>Preço R$</th>
                            @if(Auth::user()->tipo <> 'c')
                                <th>Ativo</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produto as $row)
                        @if ($row->ativo == 'a')
                            <tr class="sucess_tb" >
                        @else        
                            <tr class="warning_tb" >
                        @endif
                            <td>{{ $row->descricao }}</td>
                            <td>{{ $row->marca }}</td>
                            <td>
                                @if($row->img <> '')
                                    <a  class="pointer" onclick="abreModalImg('{{$row->img}}');"  data-toggle="modal" data-target="#modalImg">
                                        <img  height="70px" alt="" src="{{ $row->img }}" >
                                    </a>
                                @else
                                    Sem Imagem
                                @endif
                            </td>
                            <td>R$ {{ number_format($row->valor,2,",",".") }}</td>
                            @if(Auth::user()->tipo <> 'c')
                                @if ($row->ativo == 'a')
                                <td><span class="badge badge-success">Ativo</span></td>
                                @else        
                                <td><span class="badge badge-warning">Inativo</span></td>
                                @endif
                                <td>
                                    <a href="produto/{{$row->idProduto }}">
                                        <div class="btn btn-sm btn-outline-primary">
                                            <i class="fa-pencil-square-o fa"></i>
                                            Editar
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <button  onclick="abreModalExcluir('produto/excluir/{{ $row->idProduto }}');" data-toggle="modal" data-target="#modalExcluir" type="button" class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-times-circle-o"></i>
                                        Excluir
                                    </button>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // $('#tabela').DataTable( {
        //     "order": [[ 1, "asc" ]] //Ordena pela quarta coluna de forma descrescente
        // } );
    } );
</script>
@stop