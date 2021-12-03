@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/styleLogin.css') }}">
<script src="{{ asset('js/jquery.min.js') }}"></script>
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
        <div class="col-md-12">
            <!--            <div class="row">
                                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8">
                                    <div class="row">
                                        <img alt="" class="img-responsive"  src="{{ asset('img/img_login.png') }}">
                                    </div>
                                </div>
                            </div>-->
            <div class="wrap">
                <div class="" style="width: 40%; margin: 0 auto 40px auto">
                    <img alt="" src="{{ asset('img/img_login.png') }}" class="logo_login hidden-xs" style="width: 100%">
                </div>
                <p class="form-title">Login</p>
                <form class="login"  method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf
                    <input id="email" type="text" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="E-mail"/>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                    <input  id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Senha"/>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                    <input type="submit" value="Entrar" class="btn btn-success btn-sm" />
                    <div class="remember-forgot">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label style="background-color: #272D69!important;padding: 1px;border-radius: 4px">
                                        <input type="checkbox"  name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Relembrar Login') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-right " style="padding-left: 0px">
                                <!--<a href="javascription:void(0)" class="forgot-pass">Forgot Password</a>-->
<!--                                <a class="forgot-pass"  style="background-color: #272D69!important;padding: 1px;border-radius: 4px" href="#">
                                    {{ __('Esqueceu sua senha?') }}
                                </a>-->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
