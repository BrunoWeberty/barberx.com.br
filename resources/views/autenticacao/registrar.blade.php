@extends('layouts.master')

@section('registrar')
<div class="animated fadeIn">
    <div class="">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Cadastro de Cliente</strong>
                </div>
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            <form id="formulario" method="post" action="registrar/salvar" enctype="multipart/form-data" >
                                <input type="hidden"  value="{{$usuario->id}}" class="form-control-file" name="id">
                                <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="nome" class="control-label mb-1">Nome:</label>
                                            <input value="{{$usuario->nome}}" id="nome" name="nome" type="text" class="form-control required" placeholder="Nome do Usuário">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email" class="control-label mb-1">E-mail:</label>
                                            <input value="{{$usuario->email}}" id="email" name="email" type="email" class="form-control required" placeholder="E-mail do usuário">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cpf" class="control-label mb-1">CPF:</label>
                                            <input value="{{$usuario->cpf}}" id="cpf" name="cpf" type="text" class="required form-control " placeholder="CPF do usuário">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="telefone" class="control-label mb-1">Telefone:</label>
                                            <input value="{{$usuario->telefone}}" id="telefone" name="telefone" type="text" class="form-control required" placeholder="Telefone do usuário">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="sexo" class="control-label mb-1">Sexo:</label>
                                            <select class="form-control" required="" name="sexo">
                                                <option></option>
                                                <option value="f" {{($usuario->sexo == 'f'  ? 'selected' : '')}}>Feminino</option>
                                                <option value="m" {{($usuario->sexo == 'm'  ? 'selected' : '')}}>Masculino</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="login" class="control-label mb-1">Login:</label>
                                            <input value="{{$usuario->login}}" id="login" name="login" type="text" class="required form-control ">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="senha" class="control-label mb-1">Senha:</label>
                                            <input value="" id="senha" name="senha" type="password" class=" form-control ">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group has-success ">
                                            <label for="endereco" class="control-label mb-1">Endereço:</label>
                                            <input value="{{$usuario->endereco}}" placeholder="Digite o Endereço, número, etc." id="endereco" name="endereco" type="text" class="required form-control ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
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
    </div>
</div>
@include('components.js-cad')
@endsection



