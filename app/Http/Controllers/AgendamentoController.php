<?php

namespace App\Http\Controllers;

use App\Agendamento;
use App\ServAgendamento;
use App\Servico;
use App\Venda;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgendamentoController extends Controller
{
    function index($idAgendamento = 0) {
        if ($idAgendamento == null) {
            $agendamento = new Agendamento();
            $servicosAgend = [];
        } else {
            $agendamento = DB::table('agendamento')
            ->where([
                ['agendamento.deleted_at', '=', null],
                ['agendamento.idAgendamento', '=', $idAgendamento],
                ['agendamento.idCliente', '=', Auth::user()->id]])
            ->select('agendamento.idAgendamento','agendamento.idCliente','agendamento.idFunc','agendamento.dataHora','agendamento.descricao','agendamento.total','agendamento.status')
            ->first();
            $servicosAgend = DB::table('servagendamento')
            ->where([['servagendamento.deleted_at', '=', null],['servagendamento.idAgendamento', '=', $idAgendamento]])
            ->select('servagendamento.idServico')
            ->get();
        }
        $funcionarios = DB::table('usuario')
        ->where([['usuario.deleted_at', '=', null],['usuario.tipo', '=', 'f'],['usuario.status', '=', 'a']])
        ->select('usuario.*')
        ->get();  
        $servicos = DB::table('servico')
        ->where([['servico.deleted_at', '=', null],['servico.ativo', '=', 'a']])
        ->select('servico.*')
        ->get();
        return view('agendamento.cadastro', array('agendamento' => $agendamento, 'funcionarios' => $funcionarios, 'servicos' => $servicos, 'servicosAgend' => $servicosAgend));
    }

    function listar() {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        if (Auth::user()->tipo == 'c'){
            // filtragem dos agendamentos quando o usuario for cliente 
            $agendamentos = DB::table('agendamento')
            ->where([['agendamento.deleted_at', '=', null],['agendamento.idCliente', '=', Auth::user()->id]])
            ->join('usuario','usuario.id','=','agendamento.idFunc')
            ->select('agendamento.*','usuario.nome')
            ->orderBy('agendamento.dataHora')
            ->get();
            foreach ($agendamentos as $agendamento){
                $servicosAgend = DB::table('servagendamento')
                ->where([['servagendamento.deleted_at', '=', null],['servagendamento.idAgendamento', '=', $agendamento->idAgendamento]])
                ->join('servico','servico.idServico','=','servagendamento.idServico')
                ->select('servagendamento.idServico','servico.descricao','servico.valor')
                ->get();
                $agendamento->servicos = $servicosAgend;
            }
        }else{
            // caso contrário irá mostrar todos os agendamentos
            $agendamentos = DB::table('agendamento as a')
            ->where([['a.deleted_at', '=', null]])
            ->join('usuario as b','b.id','=','a.idFunc')
            ->join('usuario as c','c.id','=','a.idCliente')
            ->select('a.*','b.nome as funcionario','c.nome as cliente')
            ->whereDate('a.dataHora', date('Y-m-d'))
            ->orderBy('a.dataHora')
            ->get();
            foreach ($agendamentos as $agendamento){
                $servicosAgend = DB::table('servagendamento')
                ->where([['servagendamento.deleted_at', '=', null],['servagendamento.idAgendamento', '=', $agendamento->idAgendamento]])
                ->join('servico','servico.idServico','=','servagendamento.idServico')
                ->select('servagendamento.idServico','servico.descricao','servico.valor')
                ->get();
                $agendamento->servicos = $servicosAgend;
            }
        }
        $filtragem['data1'] = date("Y-m-d");
        $filtragem['data2'] = date("Y-m-d");
        return view('agendamento.lista', array('agendamento' => $agendamentos, 'filtragem' => $filtragem));
    }
    
    function salvar(Request $request) {
        if ($request->get('idAgendamento') == null) { 
            $agendamento = new Agendamento($request->all());
        } else {
            $agendamento = Agendamento::Where('idAgendamento', $request->get('idAgendamento'))->first();
            $agendamento->update($request->all());
        }
        $agendamento->idCliente = Auth::user()->id;
        $dataHora = $request->get('data') . " " . $request->get('hora');
        $agendamento->dataHora = $dataHora;
        try{
            // calculando o total do agendamento
            $totalServ = 0;
            if (is_array($request->servicos) || is_object($request->servicos)){
                foreach($request->servicos as $servico){
                    // calculando o total dos serviços
                    $servicoVal = DB::table('servico')
                        ->where([['servico.deleted_at', '=', null],['servico.idServico', '=', $servico]])
                        ->select('servico.valor')
                        ->first();  
                    $totalServ = $totalServ + $servicoVal->valor;
                }
            }
            $agendamento->total = $totalServ;
            $agendamento->save();

            // deletando os que já estavam salvos
            $servicosAgendDel = DB::table('servagendamento')->where('idAgendamento', '=', $agendamento->idAgendamento)->delete();
            //salvando serviços do agendamento
            if (is_array($request->servicos) || is_object($request->servicos)){
                foreach($request->servicos as $servico){
                    $servicosAgend = new ServAgendamento();
                    $servicosAgend->idAgendamento = $agendamento->idAgendamento;
                    $servicosAgend->idServico = $servico;
                    $servicosAgend->save();
                }
            }
            return redirect()->action('AgendamentoController@listar');
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('agendamento.index')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('agendamento.index')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }

    function excluir($idAgendamento = 0) { 
        if ($idAgendamento != null) {
            $agendamento = Agendamento::Where('idAgendamento', $idAgendamento)->first();
            $agendamento->delete();
        }
        return redirect()->action('AgendamentoController@listar');
    }

    function cancelar($idAgendamento = 0) {
        Agendamento::where('idAgendamento', $idAgendamento )->update(['status' => 'c']);
        return redirect()->action('AgendamentoController@listar');
    }

    function realizar($idAgendamento = 0) {
        // neste momento iremos inserir também uma venda do agendamento que está sendo realizado
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $venda = new Venda();
        $venda->created_at = now();
        $venda->status = 'f';
        $venda->obs = 'Venda realizada na realização do agendamento.';

        /* consultando informações do agendamento */
        $agendamento = DB::table('agendamento as a')
                ->where([['a.deleted_at', '=', null]])
                ->join('usuario as b','b.id','=','a.idFunc')
                ->join('usuario as c','c.id','=','a.idCliente')
                ->select('a.*','b.nome as funcionario','c.nome as cliente')
                ->where('a.idAgendamento','=',$idAgendamento)
                ->first();
        $venda->idCliente = $agendamento->idCliente;
        $servicosAgend = DB::table('servagendamento')
            ->where([['servagendamento.deleted_at', '=', null],['servagendamento.idAgendamento', '=', $agendamento->idAgendamento]])
            ->join('servico','servico.idServico','=','servagendamento.idServico')
            ->select('servagendamento.idServico','servico.descricao','servico.valor')
            ->get();
        $venda->obs = $venda->obs . ' - Serviços: ';
        foreach($servicosAgend as $serv){
            $venda->obs = $venda->obs . ' | ' . $serv->descricao . ' - R$' . number_format($serv->valor, 2, ',', ' ');
        }
        $venda->total = $agendamento->total;
        $venda->tipoPagamento = '1';
        $venda->save();

        Agendamento::where('idAgendamento', $idAgendamento )->update(['status' => 'r']);
        return redirect()->action('AgendamentoController@listar');
    }

    function agendar($idAgendamento = 0) {
        Agendamento::where('idAgendamento', $idAgendamento )->update(['status' => 'a']);
        return redirect()->action('AgendamentoController@listar');
    }

    function filtragem(Request $request){
        $agendamentos = DB::table('agendamento as a')
            ->where([['a.deleted_at', '=', null]])
            ->join('usuario as b','b.id','=','a.idFunc')
            ->join('usuario as c','c.id','=','a.idCliente')
            ->select('a.*','b.nome as funcionario','c.nome as cliente')
            ->where([['a.dataHora', '>', $request->get('data1') . ' 00:00:00'],['a.dataHora', '<', $request->get('data2') . ' 23:59:59']])
            ->orderBy('a.dataHora')
            ->get();
        foreach ($agendamentos as $agendamento){
            $servicosAgend = DB::table('servagendamento')
            ->where([['servagendamento.deleted_at', '=', null],['servagendamento.idAgendamento', '=', $agendamento->idAgendamento]])
            ->join('servico','servico.idServico','=','servagendamento.idServico')
            ->select('servagendamento.idServico','servico.descricao','servico.valor')
            ->get();
            $agendamento->servicos = $servicosAgend;
        }            

        $filtragem['data1'] = $request->get('data1');
        $filtragem['data2'] = $request->get('data2');
        return view('agendamento.lista', array('agendamento' => $agendamentos, 'filtragem' => $filtragem));
    }

    /* 
        Parâmetros:
        idFunc - funcionário
        data - a data desejada
    */
    function consultaHorarios(Request $request){
    // function consultaHorarios(){
        $data = $request->get('data');
        $idFunc = $request->get('func');
        // $data = '2021-11-23';
        // $idFunc = 2;
        /* selecionando os agendamento usando os parametros da filtragem */
        $agendamentos = DB::table('agendamento')
            ->where([
                ['agendamento.deleted_at', '=', null],
                ['agendamento.status', '=', 'a'],
                ['agendamento.idFunc', '=', $idFunc]
            ])
            ->whereDate('agendamento.dataHora', $data)
            ->select('agendamento.dataHora')
            ->get();
        
        /* fazendo um loop para selecionar os horários disponíveis de acordo com o func recebido */
        $horarios = [
            '08:00',
            '08:30',
            '09:00',
            '09:30',
            '10:00',
            '10:30',
            '11:00',
            '11:30',
            '12:00',
            '12:30',
            '13:00',
            '13:30',
            '14:00',
            '14:30',
            '15:00',
            '15:30',
            '16:00',
            '16:30',
            '17:00',
            '17:30',
            '18:00',
            '18:30',
            '19:00',
            '19:30',
            '20:00'
        ];

        foreach ($agendamentos as $agendamento){
            $dataH = new DateTime($agendamento->dataHora);
            if (in_array($dataH->format('H:i'), $horarios)) { 
                //pegando a posição do array
                $key = array_search($dataH->format('H:i'), $horarios);
                if($key !== false)
                    $horarios[$key] = '';
                    // unset($horarios[$key]);
            }
        }
        return json_encode($horarios);
    }

    /* É utilizado na venda para consultar os serviços informado no agendamento */
    function consultaAgendamento(Request $request){
        $idAgendamento = $request->get('idAgendamento');

        $agendamento = DB::table('agendamento')
            ->where([
                ['agendamento.deleted_at', '=', null],
                // ['agendamento.status', '=', 'a'],
                ['agendamento.idAgendamento', '=', $idAgendamento]
            ])
            ->select('agendamento.total')
            ->first();
        
        return json_encode($agendamento->total);
    }

}
