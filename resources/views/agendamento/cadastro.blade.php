@extends("layouts.master")
@section("conteudo")  
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Realizar Agendamento</strong>
            <a href="agendamento/listar">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Listar</span> 
                </div>
            </a>
        </div>
        <div class="card-body">
            <div id="pay-invoice">
                <div class="card-body">
                    <form id="formulario" method="post" action="agendamento/salvar" enctype="multipart/form-data" >
                        <input type="hidden" value="{{$agendamento->idAgendamento}}" class="form-control-file" name="idAgendamento">
                        <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                        <input type="hidden" value="0" class="form-control-file" name="total">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="servicos" class="control-label mb-1">Serviço:</label>
                                    <select id="servicos" name="servicos[]" data-placeholder="Selecione o(s) Serviço(s)..." class="standardSelect required" multiple  tabindex="1">
                                        @php
                                            $existe1 = false;
                                        @endphp
                                        @foreach ($servicos as $row)
                                            @foreach ($servicosAgend as $row2)
                                                @if($row->idServico == $row2->idServico)
                                                    @php
                                                        $existe1 = true;
                                                    @endphp 
                                                @else
                                                    @php
                                                        $existe1 = false;
                                                    @endphp 
                                                @endif

                                                @if ($existe1)
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach    
                                            @if ($existe1)
                                                <?= "<option selected='selected' value='" . $row->idServico . "'>" . $row->descricao . ' - R$ ' . number_format($row->valor,2,",",".") . "</option>" ?>
                                            @else
                                                <?= "<option value='" . $row->idServico . "'>" . $row->descricao . ' - R$ ' . number_format($row->valor,2,",",".") . "</option>"; ?>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="idFunc" class="control-label mb-1">Funcionário:</label>
                                    <select id="idFunc" name="idFunc" data-placeholder="Selecione o Funcionário para o serviço..." class="standardSelect required" tabindex="1" >
                                        @foreach ($funcionarios as $row)
                                            @if($row->id == $agendamento->idFunc)
                                            <option value="{{$row->id}}" selected="selected">{{$row->nome}}</option>
                                            @else
                                            <option value="{{$row->id}}">{{$row->nome}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="data" class="control-label mb-1">Data do Agendamento:</label> 
                                    <input value="{{ $agendamento->idAgendamento <> '' ? date('Y-m-d', strtotime( $agendamento->dataHora )) : '' }}" id="data" name="data" type="date" class="form-control required " >
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label mb-1"></label>
                                    <br>
                                    <button type="button" class="btn btn-info" onclick="buscaHorarios();">Consultar horários</button>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="hora" class="control-label mb-1">Horário:</label>
                                    <select id="hora" name="hora" class="required form-control" >
                                        @if ($agendamento->idAgendamento <> '')
                                            <option value="{{ date('H:i', strtotime( $agendamento->dataHora )) }}">{{ date('H:i', strtotime( $agendamento->dataHora )) }}</option>
                                        @else
                                            <option>Selecione</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label mb-1">Status:</label>
                                    @if ($agendamento->idAgendamento == '')
                                        <input type="hidden" name="status" value="a" id="status"> 
                                        <a class="pointer">
                                            <span class="badge badge-primary pointer">Agendar</span> 
                                        </a>
                                    @endif
                                    {{-- <label class="switch switch-text switch-info switch-pill">
                                        <input type="checkbox" name="status" value="a" id="status" class="switch-input" @if($agendamento->status == 'a' || $agendamento->idAgendamento == null)checked="true"@endif > 
                                        <span data-on="A" data-off="I" class="switch-label"></span> <span class="switch-handle"></span>
                                    </label>
                                    <p class="small">A: Ativo, I: Inativo</p> --}}
                                    @if ($agendamento->status == 'c')
                                    <a class="pointer">
                                        <span class="badge badge-danger pointer">Cancelado</span> 
                                    </a>
                                    @elseif($agendamento->status == 'a')
                                    <a class="pointer">
                                        <span class="badge badge-primary pointer">Agendado</span> 
                                    </a>
                                    @elseif($agendamento->status == 'r')
                                    <a class="pointer">
                                        <span class="badge badge-success pointer">Realizado</span> 
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="observacao" class="control-label mb-1">Observações:</label>
                                    <input value="{{ $agendamento->descricao }}" id="observacao" maxlength="255" name="descricao" type="text" class="form-control required " >
                                </div>
                            </div>
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
<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    /* função que busca os horários disponíveis */
    function buscaHorarios(){
        var func = $("#idFunc").val();
        var data = $("#data").val();
        if (func == '' || data == ''){
            alert('É necessário informar a Data do agendamento e o Funcionário, para trazer os horários disponíveis.');
            return;
        }
        /* veja outro evento pra colocar no lugar do change porque a busca da data ficou ruim */
        $.ajax({
            url: '/consultaHorarios',
            method: 'POST',
            data: {'func': func, 'data': data},
            beforeSend: function () {
                $('#loader').fadeIn('fast');
            },
            success: function(response) {
                var retorno = JSON.parse(response);
                $("#hora").html('');
                for (var i = 0, l = retorno.length; i < l; i++ ) {
                    if (retorno[i] != ''){
                        $("#hora").append('<option value="' + retorno[i] + '">' + retorno[i] + '</option>');
                    }
                }
                $('#loader').fadeOut('fast');
            },
            error : function(request, status, error){
                alert('Atenção, ocorreu um erro ao consultar os horários!');
                $('#loader').fadeOut('fast');
            }
        })
    }
</script>
@stop