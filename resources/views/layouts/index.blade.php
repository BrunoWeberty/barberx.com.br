@extends("layouts.master")
@section("conteudo")  
<div id="index" class="margin_top">
    <div class="card">
        <div class="card-header">
            <h4>Módulos - Acesso Rápido</h4>
        </div>
        <div class="card-body margin_top_card">

            <a href="/agendamento/listar">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-calendar fa fa-3x border_bt8"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Agendamentos</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Agendamentos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            @if(Auth::user()->tipo <> 'c')
            <a href="/marca/listar">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-compass fa fa-3x border_bt7"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Marcas</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Marcas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endif

            <a href="/produto/listar">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-shopping-cart fa fa-3x border_bt9"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Produtos</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Produtos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/promocao/listar">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-thumbs-o-up fa fa-3x border_bt1"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Promoção</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Promoção</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            @if(Auth::user()->tipo <> 'c')
            <a href="/servico/listar">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-cut fa fa-3x border_bt12"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Serviço</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Serviço</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="/venda/listar">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-money fa fa-3x border_bt4"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Venda</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Venda</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endif

            @if(Auth::user()->tipo == 'g')  
            <a href="/usuario/listar">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-user-circle fa fa-3x border_bt10"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Usuarios</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Usuarios</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a class=" pointer" data-toggle="modal" data-target="#configModal" >
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="row no_row_xs no_flex_md">
                                    <div class="stat-icon dib text_center margin_center">
                                        <i class="fa-cogs fa fa-3x border_bt2"></i>
                                    </div>
                                    <div class="stat-content dib hidden-md margin_left_xs">
                                        <div class="stat-text">Configurações</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="stat-content dib hidden-xs text-center ">
                                        <div class="stat-text text-center">Configurações</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endguest
        </div>
    </div>
</div>

@stop