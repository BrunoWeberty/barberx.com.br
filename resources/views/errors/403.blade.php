@extends('layouts.master')
@section('conteudo')
<hr/>
<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
    <span class="badge badge-pill badge-danger">Atenção</span>
    Este recurso não está disponível para seu usuário, contate o <b>administrador</b>!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endsection