@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
@include('components.modal-excluir')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">
                @if(Auth::user()->tipo == 'c')
                Listagem de Agendamentos
                @endif
                @if(Auth::user()->tipo == 'g' || Auth::user()->tipo == 'f')
                Agendamentos para hoje
                @endif
            </strong>
            @if(Auth::user()->tipo == 'c')
                <a href="agendamento/">
                    <div class="box_right pointer" >
                        <span class="btn-info pointer">Novo Agendamento</span> 
                    </div>
                </a>
            @endif
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                @if(Auth::user()->tipo == 'c')
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Funcionário</th>
                            <th>Data/Hora</th>
                            <th>Serviços</th>
                            <th>Observações</th>
                            <th>Total</th>
                            <th>Status</th>
                            {{-- <th>Editar</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agendamento as $row)
                        @if ($row->status == 'c')
                            <tr class="danger_tb" >
                        @elseif ($row->status == 'r')
                            <tr class="sucess_tb" >
                        @else
                            <tr class="warning_tb" >
                        @endif
                            <td>{{ $row->nome }}</td>
                            <td><?= date("d/m/Y H:i", strtotime($row->dataHora)) ?></td> 
                            <td>
                                <ol class="mt-1">
                                    @foreach($row->servicos as $servico)
                                    <li>{{$servico->descricao}} - R$ {{ number_format($servico->valor,2,",",".") }}</li>
                                    @endforeach
                                </ol>
                                <p class="text-right mb-0 mt-0">
                                    <span class="bold">
                                        Total: 
                                    </span>
                                    R$ {{ number_format($row->total,2,",",".") }}
                                </p> 
                            </td>
                            <td>{{ $row->descricao }}</td>
                            <td>R$ {{ number_format($row->total,2,",",".") }}</td>
                            @if ($row->status == 'c')
                            <td><span class="badge badge-danger">Cancelado</span></td>
                            @elseif ($row->status == 'r')
                            <td><span class="badge badge-success">Realizado</span></td>
                            @else
                            <td><span class="badge badge-warning">Agendado</span></td>
                            @endif
                            {{-- <td>
                                <a href="agendamento/{{$row->idAgendamento }}">
                                    <div class="btn btn-sm btn-outline-primary">
                                        <i class="fa-pencil-square-o fa"></i> 
                                        Editar
                                    </div>
                                </a>
                            </td> --}}  
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    <p>Obs.: Não será possível editar agendamentos Cancelados e Realizados.</p>
                </div>
                @endif
                @if(Auth::user()->tipo == 'g' || Auth::user()->tipo == 'f')
                    <div class="row">
                        <div class="col-12">
                            <h4>Filtrar agendamentos</h4>
                        </div>
                        <div class="col-12 mt-2">
                            <form id="formulario2" method="post" action="filtra-agendamentos">
                                <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="data1" class="control-label mb-1">Data inicial:</label>
                                            <input value="{{ $filtragem['data1'] }}" id="data1" name="data1" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="data2" class="control-label mb-1">Data final:</label>
                                            <input value="{{ $filtragem['data2'] }}" id="data2" name="data2" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="control-label mb-1"></label>
                                        <button type="submit" class="btn btn-lg btn-success btn-block">
                                            <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                                            <span>Filtrar</span>
                                        </button>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div> 
                    <div class="row mt-3">
                        @if ($agendamento->count() == 0)
                            <div class="col-6 offset-3">
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Atenção</span>
                                    Não foi encontrado nenhum agendamento para esta data.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        @foreach($agendamento as $row)
                        <div class="col-md-4 mt-4">
                            @if ($row->status == 'c')
                            <div class="card border border-danger mb-0">
                                <div class="card-header alert-danger">
                            @elseif ($row->status == 'a')
                            <div class="card border border-warning mb-0">
                                <div class="card-header alert-warning">
                            @else
                            <div class="card border border-success mb-0">
                                <div class="card-header alert-success">
                            @endif
                                    <strong class="card-title">
                                        {{ $row->idAgendamento }} - Agendamento 
                                        @if ($row->status == 'c')
                                        (Cancelado)
                                        @elseif ($row->status == 'a')
                                        (Em espera)
                                        @else
                                        (Realizado)
                                        @endif
                                    </strong>
                                    <div class="box_right">
                                        @if ($row->status == 'c')
                                            {{-- <a class="pointer" href="agendamento/realizar/{{ $row->idAgendamento }}">
                                                <span class="badge badge-success pointer">Realizar</span> 
                                            </a>
                                            <a class="pointer" href="agendamento/agendar/{{ $row->idAgendamento }}">
                                                <span class="badge badge-primary pointer">Agendar</span> 
                                            </a> --}}
                                        @elseif ($row->status == 'a')
                                            <a class="pointer" href="agendamento/cancelar/{{ $row->idAgendamento }}">
                                                <span class="badge badge-danger pointer">Cancelar</span> 
                                            </a>
                                            <a class="pointer" href="agendamento/realizar/{{ $row->idAgendamento }}">
                                                <span class="badge badge-success pointer">Realizar</span> 
                                            </a>
                                        @else
                                            {{-- <a class="pointer" href="agendamento/cancelar/{{ $row->idAgendamento }}">
                                                <span class="badge badge-danger pointer">Cancelar</span> 
                                            </a>
                                            <a class="pointer" href="agendamento/agendar/{{ $row->idAgendamento }}">
                                                <span class="badge badge-primary pointer">Agendar</span> 
                                            </a> --}}
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab{{ $row->idAgendamento }}" data-toggle="tab" href="#home{{ $row->idAgendamento }}" role="tab" aria-controls="home{{ $row->idAgendamento }}" aria-selected="true">Informações</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab{{ $row->idAgendamento }}" data-toggle="tab" href="#profile{{ $row->idAgendamento }}" role="tab" aria-controls="profile{{ $row->idAgendamento }}" aria-selected="false">Serviços</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content pl-3 p-1" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home{{ $row->idAgendamento }}" role="tabpanel" aria-labelledby="home-tab{{ $row->idAgendamento }}">
                                            <p class="card-text mt-1">
                                                <i class="menu-icon fa fa-user"></i> 
                                                {{ $row->cliente }}
                                                <br/>
                                                <i class="menu-icon fa fa-calendar-o"></i> 
                                                {{date('d/m/Y', strtotime( $row->dataHora ))}}
                                                <br/>
                                                <i class="menu-icon fa fa-clock-o"></i> 
                                                {{ date('H:i', strtotime( $row->dataHora )) }}
                                                <br/>
                                                <i class="menu-icon fa fa-magic"></i> 
                                                {{ $row->descricao }}
                                                <br/>
                                                <i class="menu-icon fa fa-scissors"></i> 
                                                {{ $row->funcionario }}
                                                <br/>
                                            </p>
                                        </div>
                                        <div class="tab-pane fade" id="profile{{ $row->idAgendamento }}" role="tabpanel" aria-labelledby="profile-tab{{ $row->idAgendamento }}">
                                            <ol class="mt-1">
                                                @foreach($row->servicos as $servico)
                                                <li>{{$servico->descricao}} - R$ {{ number_format($servico->valor,2,",",".") }}</li>
                                                @endforeach
                                            </ol>
                                            <p class="text-right mb-0 mt-0">
                                                <span class="bold">
                                                    Total: 
                                                </span>
                                                R$ {{ number_format($row->total,2,",",".") }}
                                            </p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-2">
                        <hr>
                    </div>
                    <div class="row mt-5">
                        <div class="col-xl-6">
                            <div class="card" >
                                <div class="card-header">
                                    <h4>Legenda</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card border border-success mb-0 mt-2">
                                        <div class="card-header alert-success">
                                            Concluido
                                        </div>
                                    </div>
                                    <div class="card border border-warning mb-0 mt-2">
                                        <div class="card-header alert-warning">
                                            Em espera
                                        </div>
                                    </div>
                                    <div class="card border border-danger mb-0 mt-2">
                                        <div class="card-header alert-danger">
                                            Cancelado
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop