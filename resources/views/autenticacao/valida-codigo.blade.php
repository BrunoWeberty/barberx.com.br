@extends('layouts.app')
@section('content')
<script>
$(function () {
    $('.forgot-pass').click(function (event) {
        $(".pr-wrap").toggleClass("show-pass-reset");
    });

    $('.pass-reset-submit').click(function (event) {
        $(".pr-wrap").removeClass("show-pass-reset");
    });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 col-sm-6 col-8 offset-2">
            <div class="wrap"> 
                <div class="" style="width: 100%; margin: 40px auto 40px auto; padding-top: 20px">
                    <img alt="" src="{{ asset('img/logo.png') }}" class="logo_login" style="width: 100%">
                </div>
                <p class="form-title " >Informe o código recebido pelo e-mail</p>
                <div class="">
                    <form class="login" id="form_login" method="POST" action="/valida-codigo" aria-label="{{ __('Login') }}">
                        @csrf
                        <input id="cod" type="text" class="{{ $errors->has('login') ? ' is-invalid' : '' }} color_black" name="cod" value="{{ old('login') }}" required autofocus placeholder="Código"/>
                        <input type="submit" value="Verificar"  class="btn btn-login btn-sm" />
                        <br/>
                        <br/>
                        @if(session()->has('message'))
                        <div>
                            <div style="padding: .75rem 1.05rem;" class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                                <span class="badge badge-pill badge-info">Informação!</span>
                                    <div>{{ session()->get('message') }}</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        @foreach ($errors->all() as $error)
                        <div>
                            <div style="padding: .75rem 1.05rem;" class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Acesso Negado!</span>
                                    <div>{{ $error }}</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </form>                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
