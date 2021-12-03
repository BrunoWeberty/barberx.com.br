@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.js-cad')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Filtragem de Vendas</strong>
        </div>
        <div class="card-body">
            <div id="pay-invoice">
                <div class="card-body">
                    <form id="formulario2" target="_blank" method="post" action="filtra-vendas" >
                        <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                        <div class="row">
                            <div class="col-sm-6"> 
                                <div class="form-group">
                                    <label for="idCliente" class="control-label mb-1">Cliente:</label>
                                    <select id="idCliente" name="idCliente" data-placeholder="Selecione o Cliente..." class="standardSelect " >
                                        <option value="">Geral</option>
                                        @foreach ($clientes as $row)
                                        <option value="{{$row->id}}">{{$row->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6"> 
                                <div class="form-group">
                                    <label for="idFuncionario" class="control-label mb-1">Funcionário:</label>
                                    <select id="idFuncionario" name="idFuncionario" data-placeholder="Selecione o Fabricante..." class="standardSelect " >
                                        <option value="">Selecione</option>
                                        @foreach ($funcionarios as $row)
                                        <option value="{{$row->id}}">{{$row->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="dtInicial" class="control-label mb-1">Data inicial:</label>
                                    <input value="" id="dtInicial" name="dtInicial" type="date" class="form-control ">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="dtFim" class="control-label mb-1">Data final:</label>
                                    <input value="" id="dtFim" name="dtFim" type="date" class="form-control ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a class="pointer" onclick="voltarPag();">
                                    <div class="btn btn-lg btn-primary  btn-block">
                                        <i class="fa fa-backward fa-lg"></i>&nbsp;
                                        <span>Voltar</span>
                                    </div> 
                                </a>
                            </div>
                            <div class="col-6">
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                                    <span>Gerar</span>
                                </button>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop