@extends("layouts.master")
@section("conteudo")  
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Cadastro de Marcas</strong>
            <a href="marca/listar">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Listar</span> 
                </div>
            </a>
        </div>
        <div class="card-body">
            <div id="pay-invoice">
                <div class="card-body">
                    <form id="formulario" method="post" action="marca/salvar" enctype="multipart/form-data" >
                        <input type="hidden"  value="{{$marca->idMarca}}" class="form-control-file" name="idMarca">
                        <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                        <div class="row">
                            <div class="col-sm-5">  
                                <div class="form-group">
                                    <label for="descricao" class="control-label mb-1">Nome da Marca:</label>
                                    <input value="{{$marca->descricao}}" id="decricao" name="descricao" type="text" class="form-control required" placeholder="Nome da Marca">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="img" class="control-label mb-1">Imagem da Marca:</label>
                                    <input value="{{$marca->img}}" id="img" name="img" type="file" class="form-control-file ">
                                </div>
                            </div>
                            @if(isset($marca->img))
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div data-toggle="tooltip" data-placement="right" title="*Já existe imagem para este registro, se deseja alterar apenas insira uma nova, caso contrário deixe o campo em branco.">
                                            <a  class="pointer" onclick="abreModalImg('{{$marca->img}}');"  data-toggle="modal" data-target="#modalImg">
                                                <label class="control-label mb-1">Imagem atual:</label>
                                                <br/> 
                                                <img  height="70px" alt="" src="{{ $marca->img }}" >
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                    <span>Salvar</span>
                                </button>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- js da tela de cadastro --}}
@include('components.js-cad')
@include('components.modal-img')
@stop