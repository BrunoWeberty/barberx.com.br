@extends("layouts.master")
@section("conteudo")  
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Realizar Venda</strong>
            <a href="venda/listar">
                <div class="box_right pointer" >
                    <span class="btn-info pointer">Listar</span> 
                </div>
            </a>
        </div>
        <div class="card-body">
            <div id="pay-invoice">
                <div class="card-body">
                    @if($venda->idVenda <> '')
                        <div>
                            <div style="padding: .75rem 1.05rem;" class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Atenção!</span>
                                Não será possível editar uma venda já realizada!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <form id="formulario" method="post" action="venda/salvar" enctype="multipart/form-data" >
                        <input type="hidden"  value="{{$venda->idVenda}}" class="form-control-file" name="idVenda">
                        <input type="hidden" name="_token" value ="{{csrf_token()}}" />
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="idCliente" class="control-label mb-1">Cliente:</label>
                                    <select id="idCliente" name="idCliente" data-placeholder="Selecione o Cliente para realizar a venda..." class="standardSelect required"  >
                                        @foreach ($clientes as $row)
                                            @if($row->id == $venda->idCliente)
                                            <option value="{{$row->id}}" selected="selected">{{$row->nome}}</option>
                                            @else
                                            <option value="{{$row->id}}">{{$row->nome}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="produtos" class="control-label mb-1">Produtos:</label>
                                    <select id="produtos" name="produtos[]" data-placeholder="Selecione o(s) Produto(s) da venda..." class="standardSelect required" multiple  onchange="calculaVenda()">
                                        @php
                                            $existe1 = false;
                                        @endphp
                                        @foreach ($produtos as $row)
                                            @foreach ($itemVenda as $row2)
                                                @if($row->idProduto == $row2->idProduto)
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
                                                <?= "<option selected='selected' value='" . $row->idProduto . "'>" . $row->descricao . ' - R$ ' . number_format($row->valor,2,",",".") . "</option>" ?>
                                            @else
                                                <?= "<option value='" . $row->idProduto . "'>" . $row->descricao . ' - R$ ' . number_format($row->valor,2,",",".") . "</option>"; ?>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="idAgendamento" class="control-label mb-1">Vincular Agendamento:</label>
                                    {{-- campo apenas para salvar o valor total do agendamento --}}
                                    <input type="hidden" value="0" id="totalAgendamento" name="totalAgendamento">
                                    <select id="idAgendamento" name="idAgendamento" data-placeholder="Selecione o Cliente para realizar a venda..." class="standardSelect required"  onchange="buscaAgendamento();">
                                        <option value="">Nenhum</option>
                                        @foreach ($agendamentos as $row)
                                            @if($row->idAgendamento == $venda->idAgendamento)
                                            <option value="{{$row->idAgendamento}}" selected="selected">{{$row->cliente}} - R$ {{ number_format($row->total,2,",",".") }} - <?= date("d/m/Y H:i", strtotime($row->dataHora)) ?></option>
                                            @else
                                            <option value="{{$row->idAgendamento}}">{{$row->cliente}} - R$ {{ number_format($row->total,2,",",".") }} - <?= date("d/m/Y H:i", strtotime($row->dataHora)) ?></option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="idPromocao" class="control-label mb-1">Promoção:</label>
                                    <select id="idPromocao" name="idPromocao" data-placeholder="Selecione o Cliente para realizar a venda..." class="standardSelect required" onchange="calculaVenda()">
                                        <option value="">Nenhuma</option>
                                        @foreach ($promocoes as $row)
                                            @if($row->idPromocao == $venda->idPromocao)
                                            <option value="{{$row->idPromocao}}" selected="selected">{{$row->descricao}} - {{ $row->porcentagem }}%</option>
                                            @else
                                            <option value="{{$row->idPromocao}}">{{$row->descricao}} - {{ $row->porcentagem }}%</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="row form-group">
                                    <label for="total" class="control-label mb-1">Total:</label> 
                                    <div class="col col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-addon">R$</div>
                                            <input value="{{$venda->total}}" readonly min="0" id="total" name="total" type="number" class="form-control required" placeholder="9,99">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tipoPagamento" class="control-label mb-1">Tipo Pagamento:</label>
                                    <select id="tipoPagamento" name="tipoPagamento" class="standardSelect required"  >
                                        <option value="1">Dinheiro</option>
                                        <option value="2">Cartão</option>
                                        <option value="3">Pix</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">  
                                <div class="form-group">
                                    <label for="obs" class="control-label mb-1">Observações:</label>
                                    <textarea name="obs" id="obs" class="form-control" rows="4">{{$venda->obs}}</textarea>
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
                            @if($venda->idVenda == '')
                                <div class="col-6">
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                                        <span>Salvar</span>
                                    </button>
                                </div> 
                            @endif
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

    /* realiza a consulta dos serviços prestados no agendamento */
    function buscaAgendamento(){
        var idAgendamento = $("#idAgendamento").val();
        if (idAgendamento != ""){
            /* veja outro evento pra colocar no lugar do change porque a busca da data ficou ruim */
            $.ajax({
                url: '/consultaAgendamento',
                method: 'POST',
                data: {'idAgendamento': idAgendamento},
                beforeSend: function () {
                    $('#loader').fadeIn('fast');
                },
                success: function(response) {
                    var retorno = JSON.parse(response);
                    $("#totalAgendamento").val(retorno);
                    $('#loader').fadeOut('fast');
                    calculaVenda();
                },
                error : function(request, status, error){
                    alert('Atenção, ocorreu um erro ao consultar os horários!');
                    $('#loader').fadeOut('fast');
                }
            })
        }
    }

    /* realiza a soma total da venda */
    function calculaVenda(){
        var total = 0, totalAgendamento, produtos, promocao, desconto;
        /* somando agendamento */
        totalAgendamento = $("#totalAgendamento").val();
        if (totalAgendamento != 0 && totalAgendamento != ''){
            total = parseFloat(total) + parseFloat(totalAgendamento);
        }

        /* capturando o valor do desconto se for informado */
        promocao = $("#idPromocao").val();
        if (promocao != ''){
            desconto = ($("#idPromocao  :selected").text()).substr(-3);
            desconto = (desconto.substr(0, 2)) / 100;
        }
        
        /* calculando os produtos */
        produtos = $("#produtos").val();
        if (produtos != '' && produtos != [] && produtos != '[]' && produtos != null){
            /* neste caso iremos fazer a consulta do total dos produtos informados */
            $.ajax({
                url: '/consultaTotalProds',
                method: 'POST',
                data: {'produtos': produtos},
                beforeSend: function () {
                    $('#loader').fadeIn('fast');
                },
                success: function(response) {
                    var retorno = JSON.parse(response);
                    total = total + parseFloat(retorno);
                    if (promocao != ''){
                        total = total - (total * desconto);
                        $("#total").val(total.toFixed(2));
                    }else
                        $("#total").val(total.toFixed(2));
                    $('#loader').fadeOut('fast');
                },
                error : function(request, status, error){
                    alert('Atenção, ocorreu um erro ao consultar o total dos produtos!');
                    $('#loader').fadeOut('fast');
                }
            })
        }else{
            if (promocao != ''){
                total = total - (total * desconto);
                $("#total").val(total.toFixed(2));
            }else
                $("#total").val(total.toFixed(2));
        }
    }
</script>
@stop