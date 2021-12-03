@extends("layouts.master")
@section("conteudo") 
{{-- js da tela de listagem --}}
@include('components.js-lista')
<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Listagem de Auditorias</strong>
            <p>
                Todas as alterações/exclusões realizadas no sistema, são listadas aqui.
            </p>
        </div>
        <div class="col-lg-12">
            <div id="" class="margin_top margin_bottom">
                <table id="tabela" class="table dt-responsive nowrap w-100 border_bt_tb">
                    <thead>
                        <tr>
                            <th>Cod. Usuário</th>
                            <th>Evento</th>
                            <th>Alteração em</th>
                            <th>Valor Anterior</th>
                            <th>Novo Valor</th>
                            <th>IP</th>
                            <th>Navegador</th>
                            <th>Horário</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auditorias as $row)
                        <tr>
                            <td>{{ $row->user_id }}</td>
                            <td>{{ $row->event }}</td>
                            <td>{{ $row->auditable_type }}</td>
                            <td>{{ $row->old_values }}</td>
                            <td>{{ $row->new_values }}</td>
                            <td>{{ $row->ip_address }}</td>
                            <td>{{ $row->user_agent }}</td>
                            <td>{{ $row->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop