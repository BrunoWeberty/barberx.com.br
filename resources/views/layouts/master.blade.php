<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
//$url_host = "http://" . $_SERVER['HTTP_HOST']."/public/";
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <base href="<?= "https://".$_SERVER['HTTP_HOST']."/" ?>"/>
        <meta name="description" content="Barber X - O controle de sua Barbearia">
        <meta property="og:title" content="Barber X - O controle de sua Barbearia" />
        <meta property="og:site_name" content="Barber X - O controle de sua Barbearia" />
        <meta property="og:type" content="system" />
        <meta property="og:description" content="Barber X - O controle de sua Barbearia" />
        <meta property="og:url" content="{{$_SERVER['HTTP_HOST']}}" />
        <meta property="og:image" content="{{ asset('img/logo.png') }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Bruno W.">
        <!------------------------>
        <!-- | Begin CSS | -->
        <link rel="apple-touch-icon" href="{{ asset('img/icon-logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('img/icon-logo.png') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/scss/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
        <!-- | End CSS | -->
        <!-- | Begin JS  |-->
        <script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script> --}}
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <!-- | End JS | -->
        <!------------------------>
        <script>
        $(function () {
            $(window).load(function () {
                $('#loader').fadeOut('fast');
            });
        });
        function usuarioMenu(){
            @if((isset(Auth::user()->menu)))
            $.ajax({ 
                type: "GET",
                url: "alteraMenu",
                beforeSend: function () {
                    $('#informacao_p').text('Aguarde, salvando configuração.');
                    $('#loader').fadeIn('fast');
                },
                success: function (data) {
                    $('#informacao_p').text('');
                    $('#loader').fadeOut('fast');
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            }); 
            @endif
        }
        </script>
    </head>
    <body class="@if((isset(Auth::user()->menu)) && (!(Auth::user()->menu == 'a' || Auth::user()->menu == ''))) open @endif">
        <!-- | Begin Loader | -->
        <div id="loader" class=" text-center">
            <img alt="loader" src="{{ asset('img/loader.svg') }}" class="img-responsive">
            <p id="informacao_p">
                
            </p>
        </div>
        <!-- | End Loader | -->
        <!-- | Begin Lateral Bar | -->
        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default">
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand logo_top" href="./home"> 
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                    </a>
                    <a class="navbar-brand hidden" href="home">
                        <h5 class="text_white small">
                            M
                            <br/>
                            R
                            <br/>
                            B
                        </h5>
                        <!--<img src="images/logo2.png" alt="Logo">-->
                    </a>
                </div>
                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        @guest
                        <li>
                            <a href="{{ route('login') }}" class="animate">
                                <span class="desc animate"> Login </span>
                                <span class="mdi mdi-18px mdi-account"></span>
                            </a>
                        </li>
                        @else
                        <li> {{-- class="active" --}}
                            <a href="home"> <i class="menu-icon fa fa-dashboard"></i>Início</a>
                        </li><span class="hidden-xs"><hr/></span>

                        <h3 class="menu-title"></h3>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Agendamentos</a>
                            <ul class="sub-menu children dropdown-menu">
                                @if(Auth::user()->tipo == 'c')
                                    {{-- apenas usuario cliente poderá cadastrar agendamentos --}}
                                    <li><i class="menu-icon fa fa-plus-square-o"></i><a href="agendamento">Cadastrar</a></li>
                                @endif
                                <li><i class="menu-icon fa fa-list"></i><a href="agendamento/listar">Listar</a></li>
                            </ul>
                        </li><span class="hidden-xs"><hr/></span>
                        
                        <h3 class="menu-title"></h3>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-shopping-cart"></i>Produtos</a>
                            <ul class="sub-menu children dropdown-menu">
                                @if(Auth::user()->tipo <> 'c')
                                <li><i class="menu-icon fa fa-compass"></i><a href="<?php $url_host ?>/marca/listar">Marcas</a></li>
                                <li><i class="menu-icon fa fa-plus-square-o"></i><a href="<?php $url_host ?>/produto">Cadastrar Produto</a></li>
                                @endif
                                <li><i class="menu-icon fa fa-list"></i><a href="<?php $url_host ?>/produto/listar">Listar Produtos</a></li>
                            </ul>
                        </li><span class="hidden-xs"><hr/></span>

                        <h3 class="menu-title"></h3>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-thumbs-o-up"></i>Promoção</a>
                            <ul class="sub-menu children dropdown-menu">
                                @if(Auth::user()->tipo <> 'c')
                                    <li><i class="menu-icon fa fa-plus-square-o"></i><a href="promocao">Cadastrar</a></li>
                                @endif
                                <li><i class="menu-icon fa fa-list"></i><a href="promocao/listar">Listar</a></li>
                            </ul>
                        </li><span class="hidden-xs"><hr/></span>

                        @if(Auth::user()->tipo <> 'c')
                        <h3 class="menu-title"></h3>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cut"></i>Serviço</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon fa fa-plus-square-o"></i><a href="servico">Cadastrar</a></li>
                                <li><i class="menu-icon fa fa-list"></i><a href="servico/listar">Listar</a></li>
                            </ul>
                        </li><span class="hidden-xs"><hr/></span>

                        <h3 class="menu-title"></h3>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Venda</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon fa fa-plus-square-o"></i><a href="venda">Cadastrar</a></li>
                                <li><i class="menu-icon fa fa-list"></i><a href="venda/listar">Listar</a></li>
                            </ul>
                        </li><span class="hidden-xs"><hr/></span>
                        <h3 class="menu-title"></h3>
                        
                        <li> 
                            <a href="relatorio-vendas"> <i class="menu-icon fa fa-file-text-o"></i>Relatório Vendas</a>
                        </li><span class="hidden-xs"><hr/></span>
                        <h3 class="menu-title"></h3>

                        <li> 
                            <a href="grafico"> <i class="menu-icon fa fa-bar-chart-o"></i>Gráfico Vendas</a>
                        </li><span class="hidden-xs"><hr/></span>
                        @endif

                        <!--acesso somente para usuarios adm-->
                        @guest
                        
                        @else

                        @if(Auth::user()->tipo == 'g')
                            <h3 class="menu-title"></h3>
                            <li class="menu-item-has-children dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i>Usuários</a>
                                <ul class="sub-menu children dropdown-menu">
                                    <li><i class="menu-icon fa fa-plus-square-o"></i><a href="<?php $url_host ?>/usuario">Cadastrar</a></li>
                                    <li><i class="menu-icon fa fa-list"></i><a href="<?php $url_host ?>/usuario/listar">Listar</a></li>
                                </ul>
                            </li><span class="hidden-xs"><hr/></span>
                        @else
                        
                        @endif
                        @endguest
                        <li>
                            <a  href="{{ route('logout') }}">
                                <span class="desc animate"> Sair </span>
                                <span class="mdi mdi-18px mdi-logout-variant "></span>
                            </a>
                        </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </aside>
        <!-- | End Lateral Bar | -->
        <!-- Right Panel -->
        <div id="right-panel" class="right-panel" >
            <!-- Header-->
            <header id="header" class="header">
                <div class="header-menu">

                    <div class="col-sm-7">
                        <a id="menuToggle" onclick="usuarioMenu();" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                        <div class="header-left">
                            {{-- <button class="search-trigger"><i class="fa fa-search"></i></button>
                            <div class="form-inline">
                                <form class="search-form">
                                    <input class="form-control mr-sm-2" type="text" placeholder="Pesquisar ..." aria-label="Pesquisar">
                                    <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                                </form>
                            </div> --}}

                            <div class="dropdown for-notification"  style="display: none;">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="count bg-danger">5</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="notification"  style="display: none;">
                                    <p class="red">Você possui 3 notificações.</p>
                                    <a class="dropdown-item media bg-flat-color-1" href="#">
                                        <i class="fa fa-check"></i>
                                        <p class="text-white">Novos dados encontrados.</p>
                                    </a>
                                    <a class="dropdown-item media bg-flat-color-4" href="#">
                                        <i class="fa fa-info"></i>
                                        <p class="text-white">Relatórios concluidos.</p>
                                    </a>
                                    <a class="dropdown-item media bg-flat-color-5" href="#">
                                        <i class="fa fa-warning"></i>
                                        <p class="text-white">Processo de finalização executado.</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="user-area dropdown float-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="user-avatar rounded-circle" src="{{ asset('img/avatar/user.png') }}" alt="">
                            </a>
                            @guest

                            @else
                            <span id="name_user">
                                {{ Auth::user()->nome }}
                            </span>
                            @endguest
                            <div class="user-menu dropdown-menu">
                                @guest
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                <a class="nav-link" href="home"></a>
                                @else 
                                @if(Auth::user()->tipo == 'c')
                                    <a class="nav-link" ><i class="fa fa-flag"></i>Cliente</a>
                                @elseif(Auth::user()->tipo == 'f')
                                    <a class="nav-link" ><i class="fa fa-flag"></i>Funcionário</a>
                                @else
                                    <a class="nav-link" ><i class="fa fa-flag"></i>Administrador</a>
                                @endif
                                <!--<a class="nav-link" href="#"><i class="fa fa- user"></i>Meus Dados</a>-->
                                @if(Auth::user()->tipo == 'g')  
                                    @if(!isset(explode('/', Request::url())[3]) || (isset(explode('/', Request::url())[3]) && explode('/', Request::url())[3] == 'home') || (isset(explode('/', Request::url())[3]) && explode('/', Request::url())[3] == 'index'))
                                        <a class="nav-link pointer" data-toggle="modal" data-target="#configModal" ><i class="fa fa -cog"></i>Configurações</a>
                                    @endif
                                @endif
                                @if(Auth::user()->tipo == 'c')
                                    <a class="nav-link" href="/usuario/{{Auth::user()->id}}" ><i class="fa fa-user"></i> Meus dados</a>
                                @endif
                                <a class="nav-link" href="#" style="display: none;"><i class="fa fa- user"></i>Notificações <span class="count">13</span></a>
                                <a class="nav-link pointer" data-toggle="modal" data-target="#mediumModal" ><i class="fa fa -cog"></i>Sobre</a>

                                <a class="nav-link" href="{{ route('logout') }}" >
                                    {{ __('Sair') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Header-->
            
            <div class="breadcrumbs">
                <div class="col-sm-9">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>
                                {{ config('app.name', 'Laravel') }} @if(isset($configuracoes)) {{$configuracoes->empresa}} @endif
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 ">
                    <div class="page-header float-right">
                        <div class="page-title text_right_xs right_xs">
                            <ol class="breadcrumb text-right">
                                <li class="active"><a><?= date("d/m/Y | H:i") ?></a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content mt-3 no_margim">
                @guest
                <div class="sufee-alert alert with-close alert-dark alert-dismissible fade show">
                    <span class="badge badge-pill badge-dark">Atenção</span>
                    Realize seu cadastro para poder acessar o sistema.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    @yield("registrar")
                @else
                
                @if(session()->has('message'))
                <div class="margin_top">
                    <div style="padding: .75rem 1.05rem;" class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                        <span class="badge badge-pill badge-info">Informação!</span>
                        {{ session()->get('message') }}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif

                @foreach ($errors->all() as $error)
                <div class="margin_top">
                    <div style="padding: .75rem 1.05rem;" class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span class="badge badge-pill badge-danger">Atenção!</span>
                          {{ $error }}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endforeach

                <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Informações do sistema</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <h6>
                                            <span style="font-size: 0.7em">
                                                <strong>{{ config('app.name', 'Laravel') }}</strong> | &copy;opyright  <script type="text/javascript">document.write(new Date().getFullYear());</script>
                                                <br/>
                                                <span style="font-size: 0.9em" class="">[Developer: Bruno W.]</span>
                                                <br>
                                                <span style="font-weight: 100">Versão do sistema:</span> @if(isset($configuracoes)) {{$configuracoes->versao}} @else 1.0 @endif
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="row">
                                        -- colocar a logo aqui futuramente --
                                    </div>
                                </div> --}}
                            </div>
                            <div class="modal-footer">
                                <span style="font-size: 0.8em">
                                    A melhor maneira de prever o futuro é inventá-lo.
                                    <span style="font-size: 0.9em">
                                        Alan Kay
                                    </span>
                                </span>
                                <!--<button type="button" class="btn btn-secondary" >Cancel</button>-->
                                <!--<button type="button" class="btn btn-primary" data-dismiss="modal"></button>-->
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->tipo == 'g' and isset($configuracoes))
                <div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="configModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form id="formulario2" method="post" action="configuracoes" enctype="multipart/form-data" >
                                <input type="hidden"  value="{{$configuracoes->id}}" class="form-control-file" name="id">
                                <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mediumModalLabel">Configurações do Sistema</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <div class="small">
                                            <p>Atenção, altere essas configurações com bastante cautela, pois isso afeta em vários locais em seu site.</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group has-success">
                                                    <label for="titulo" class="control-label mb-1">Título da URL:</label>
                                                    <input value="{{$configuracoes->titulo}}" id="titulo" name="titulo" type="text" class="form-control required " placeholder="Título do WebSite" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" hidden>
                                            <div class="col-sm-12">
                                                <div class="form-group has-success">
                                                    <label for="descricao" class="control-label mb-1">Descrição do site:</label>
                                                    <input value="{{$configuracoes->descricao}}" id="descricao" name="descricao" type="text" class="form-control required " placeholder="Descrição do WebSite" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" hidden>
                                            <div class="col-sm-6">
                                                <div class="form-group has-success">
                                                    <label for="keywords" class="control-label mb-1">Keywords (palavras-chaves para encontrar seu site):</label>
                                                    <input value="{{$configuracoes->keywords}}" id="keywords" name="keywords" type="text" class="form-control required " placeholder="Separe as palavras por vírgula" >
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-success">
                                                    <label for="url" class="control-label mb-1">URL:</label>
                                                    <input value="{{$configuracoes->url}}" id="url" name="url" type="text" class="form-control required " placeholder="Descrição do WebSite" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group has-success">
                                                    <label for="favicon" class="control-label mb-1">Favicon:</label>
                                                    <input value="{{$configuracoes->favicon}}" id="favicon" name="favicon" type="file" class="form-control-file ">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                @if(isset($configuracoes->favicon))
                                                <div class="form-group">
                                                    <div data-toggle="tooltip" data-placement="right">
                                                        <a target="_blank" href="{{$configuracoes->favicon}}">
                                                        <label class="control-label mb-1">Favicon atual:</label>
                                                        <br/> 
                                                            <img  height="30px" alt="" src="{{ $configuracoes->favicon }}" >
                                                        </a>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group has-success">
                                                    <label for="logo" class="control-label mb-1">Logo:</label>
                                                    <input value="{{$configuracoes->logo}}" id="logo" name="logo" type="file" class="form-control-file ">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                @if(isset($configuracoes->logo))
                                                <div class="form-group">
                                                    <div data-toggle="tooltip" data-placement="right">
                                                        <a target="_blank" href="{{ $configuracoes->logo }}">
                                                        <label class="control-label mb-1">Logo atual:</label>
                                                        <br/> 
                                                            <img  height="50px" alt="" src="{{ $configuracoes->logo }}" >
                                                        </a>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-7" hidden>
                                                <div class="form-group has-success">
                                                    <label for="nomeAplicacao" class="control-label mb-1">Nome da Aplicação:</label>
                                                    <input value="{{$configuracoes->nomeAplicacao}}" id="nomeAplicacao" name="nomeAplicacao" type="text" class="form-control required " placeholder="Endereço de e-mail" >
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="form-group has-success">
                                                    <label for="email2" class="control-label mb-1">E-mail p/ receber e-mails de contato:</label>
                                                    <input value="{{$configuracoes->email2}}" id="email2" name="email2" type="email" class="form-control required " placeholder="Endereço de e-mail" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" hidden>
                                            <div class="col-sm-4">
                                                <div class="form-group has-success">
                                                    <label for="emailHost" class="control-label mb-1">Host(Servidor) de envio:</label>
                                                    <input value="{{$configuracoes->emailHost}}" id="emailHost" name="emailHost" type="text" class="form-control required " placeholder="Servidor de e-mail" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group has-success">
                                                    <label for="email" class="control-label mb-1">E-mail para envio de e-mails:</label>
                                                    <input value="{{$configuracoes->email}}" id="email" name="email" type="email" class="form-control required " placeholder="Endereço de e-mail" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group has-success">
                                                    <label for="emailSenha" class="control-label mb-1">Senha do E-mail:</label>
                                                    <input value="{{$configuracoes->emailSenha}}" id="emailSenha" name="emailSenha" type="password" class="form-control required " >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group has-success">
                                                    <label for="inicioLicenca" class="control-label mb-1">Data de Início da licença:</label>
                                                    <input readonly value="{{$configuracoes->inicioLicenca}}" id="inicioLicenca" name="inicioLicenca" type="date" class="form-control required " placeholder="Servidor de e-mail" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group has-success">
                                                    <label for="fimLicenca" class="control-label mb-1">Data de Fim da licença:</label>
                                                    <input readonly value="{{$configuracoes->fimLicenca}}" id="fimLicenca" name="fimLicenca" type="date" class="form-control required " placeholder="Endereço de e-mail" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4" hidden>
                                                <div class="form-group has-success">
                                                    <label for="empresa" class="control-label mb-1">Nome da Empresa:</label>
                                                    <input value="{{$configuracoes->empresa}}" id="empresa" name="empresa" type="text" class="form-control required " >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal" aria-label="Close" >Cancelar</button>
                                    <button id="payment-button2" type="submit" class="btn btn-success">
                                        <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                                        <span>Salvar</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @yield("conteudo")
                @endguest      
            <!--    <div class="col-sm-12">
                        <div class="alert  alert-success alert-dismissible fade show" role="alert">
                            <span class="badge badge-pill badge-success">Parabéns</span> Login realizado com sucesso!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>-->
            </div>
        </div> 
    </body>
</html>