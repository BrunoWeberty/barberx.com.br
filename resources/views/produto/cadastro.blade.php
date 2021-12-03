@extends("layouts.master")
@section("conteudo")  
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Cadastro de Produtos</strong>
            <a href="produto/listar">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Listar</span> 
                </div>
            </a>
        </div>
        <div class="card-body">
            <div id="pay-invoice">
                <div class="card-body">
                    <form id="formulario" method="post" action="produto/salvar" enctype="multipart/form-data" >
                        <input type="hidden"  value="{{$produto->idProduto}}" class="form-control-file" name="idProduto">
                        <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label for="descricao" class="control-label mb-1">Descrição:</label>
                                    <input value="{{$produto->descricao}}" id="descricao" name="descricao" type="text" class="form-control " placeholder="Descrição do Produto">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="marca" class="control-label mb-1">Marca:</label>
                                    <select id="marca" name="marca" data-placeholder="Selecione a Marca..." class="standardSelect required" tabindex="1">
                                        @foreach ($marca as $row)
                                        @if($row->idMarca == $produto->idMarca)
                                        <option value="{{$row->idMarca}}" selected="selected">{{$row->descricao}}</option>
                                        @else
                                        <option value="{{$row->idMarca}}">{{$row->descricao}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="valor" class="control-label mb-1">Preço:</label> 
                                    <input value="{{$produto->valor}}" min="0" id="valor" name="valor" type="number" class="form-control required" placeholder="R$ 59,99">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ativo" class="control-label mb-1">Status:</label>
                                    <label class="switch switch-text switch-info switch-pill">
                                        <input type="checkbox" name="ativo" value="a" id="ativo" class="switch-input" @if($produto->ativo == 'a' || $produto->idProduto == null)checked="true"@endif > 
                                        <span data-on="A" data-off="I" class="switch-label"></span> <span class="switch-handle"></span>
                                    </label>
                                    <p class="small">A: Ativo, I: Inativo</p>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="img" class="control-label mb-1">Imagem: *campo obrigatório</label>
                                    <input value="{{$produto->img}}" id="img" name="img" type="file" class="form-control-file ">
                                </div>
                            </div>
                            @if(isset($produto->img))
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div data-toggle="tooltip" data-placement="right" title="*Já existe imagem para este registro, se deseja alterar apenas insira uma nova, caso contrário deixe o campo em branco.">
                                            <a class="pointer" onclick="abreModalImg('{{$produto->img}}');"  data-toggle="modal" data-target="#modalImg">
                                                <label class="control-label mb-1">Imagem atual:</label>
                                                <br/> 
                                                <img  height="70px" alt="" src="{{ $produto->img }}" >
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