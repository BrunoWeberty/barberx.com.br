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
                <p class="form-title " >Login</p>
                <div class="">
                    <form class="login" id="form_login" method="POST" action="{{route ('logar')}}" aria-label="{{ __('Login') }}">
                        @csrf
                        <input id="login" type="text" class="{{ $errors->has('login') ? ' is-invalid' : '' }} color_black" name="login" value="{{ old('login') }}" required autofocus placeholder="Login"/>
                        <input  id="senha" type="password" class="{{ $errors->has('senha') ? ' is-invalid' : '' }} color_black" name="senha" required placeholder="Senha"/>
                        <input type="submit" value="Entrar" class="btn btn-login btn-sm" />
                        <a href="/registrar" class="btn btn-success" style="width: 100%">CADASTRE-SE</a>
                        <a href="/login/google" class="btn btn-danger btn-sm mt-1" style="width: 100%;">
                            <i class="fa fa-google-plus"></i> 
                            <span class="text_white">Entrar com Google</span>
                        </a>
                        <div class="remember-forgot">
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6 text-right " style="padding-left: 0px">
                                </div>
                            </div>
                        </div>
                        <br/>
                        <br/>
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
                        @if(session()->has('message'))
                        <div>
                            <div style="padding: .75rem 1.05rem;" class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                                <span class="badge badge-pill badge-info">Sucesso!</span>
                                    <div>{{ session()->get('message') }}</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                    </form>                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
