<?php

namespace App\Http\Controllers;

use App\Agendamento;
use App\ItemVenda;
use App\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    function index($idVenda = 0) {
        if ($idVenda == null) {
            $venda = new Venda();
            $itemVenda = [];
        } else {
            $venda = Venda::Where('idVenda', $idVenda)->first();
            $itemVenda = DB::table('itemvenda')
            ->where([['itemvenda.deleted_at', '=', null],['itemvenda.idVenda', '=', $idVenda]])
            ->select('itemvenda.*')
            ->get();
        }
        $clientes = DB::table('usuario')
        ->where([['usuario.deleted_at', '=', null],['usuario.tipo', '=', 'c'],['usuario.status', '=', 'a']])
        ->select('usuario.*')
        ->get();  
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        /* enviando apenas os agendamentos do dia */
        $agendamentos = DB::table('agendamento as a')
            ->where([['a.deleted_at', '=', null]])
            ->join('usuario as b','b.id','=','a.idFunc')
            ->join('usuario as c','c.id','=','a.idCliente')
            ->select('a.*','b.nome as funcionario','c.nome as cliente')
            ->whereDate('a.dataHora', date('Y-m-d'))
            ->where('a.status', '=', 'a')
            ->orderBy('a.dataHora')
            ->get();
        $produto = DB::table('produto')
            ->join('marca','marca.idMarca','=','produto.idMarca')
            ->select('produto.*','marca.descricao as marca')
            ->where([['produto.deleted_at','=',null],['produto.ativo', '=', 'a']])
            ->orderBy('idProduto', 'DESC')
            ->get();
        $promocoes = DB::table('promocao')
            ->where([['promocao.deleted_at', '=', null],['promocao.ativo', '=', 'a']])
            ->select('promocao.*')
            ->get();
        return view('venda.cadastro', array('venda' => $venda, 'clientes' => $clientes, 'agendamentos' => $agendamentos, 'produtos' => $produto, 'itemVenda' => $itemVenda, 'promocoes' => $promocoes));
    }

    function listar() {
        $venda = DB::table('venda as a')
        ->where([['a.deleted_at', '=', null]])
        ->join('usuario as c','c.id','=','a.idCliente')
        ->select('a.*','c.nome as cliente')
        ->get();

        foreach ($venda as $vend){
            $itemVenda = DB::table('itemvenda')
            ->where([['itemvenda.deleted_at', '=', null],['itemvenda.idVenda', '=', $vend->idVenda]])
            ->select('itemvenda.*')
            ->get();
            $vend->itemVenda = $itemVenda;
        }
        return view('venda.lista', array('venda' => $venda));
    }
    
    function salvar(Request $request) {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        if ($request->get('idVenda') == null) { 
            $venda = new Venda($request->all());
        } else {
            $venda = Venda::Where('idVenda', $request->get('idVenda'))->first();
            $venda->update($request->all());
        }
        $venda->created_at = now();
        $venda->status = 'f';
        $venda->obs = $request->get('obs');

        if ($request->get('idAgendamento') <> ''){
            /* consultando informações sobre o agendamento */
            $agendamento = DB::table('agendamento as a')
                ->where([['a.deleted_at', '=', null]])
                ->join('usuario as b','b.id','=','a.idFunc')
                ->join('usuario as c','c.id','=','a.idCliente')
                ->select('a.*','b.nome as funcionario','c.nome as cliente')
                ->where('a.idAgendamento','=',$request->get('idAgendamento'))
                ->first();
            $servicosAgend = DB::table('servagendamento')
                ->where([['servagendamento.deleted_at', '=', null],['servagendamento.idAgendamento', '=', $agendamento->idAgendamento]])
                ->join('servico','servico.idServico','=','servagendamento.idServico')
                ->select('servagendamento.idServico','servico.descricao','servico.valor')
                ->get();
            $venda->obs = $venda->obs . ' - Serviços: ';
            foreach($servicosAgend as $serv){
                $venda->obs = $venda->obs . ' | ' . $serv->descricao . ' - R$' . number_format($serv->valor, 2, ',', ' ');
            }
            /* colocando agendamento como resolvido! */
            Agendamento::where('idAgendamento', $request->get('idAgendamento'))->update(['status' => 'r']);
        }

        /* se foi informado uma promoção vamos salvar na obs tb */
        if ($request->get('idPromocao') <> ''){
            $promocao = DB::table('promocao')
            ->where([['promocao.deleted_at', '=', null],['promocao.idPromocao', '=', $request->get('idPromocao')]])
            ->select('promocao.*')
            ->first();
            $venda->obs = $venda->obs . ' - Foi concedido a promoção: ' . $promocao->descricao . ', com ' . $promocao->porcentagem . '% de desconto.';
        }

        try{
            $venda->save();

            /* ------- salvando os item da venda ------- */
            // deletando os que já estavam salvos
            $itemVendaDelete = DB::table('itemvenda')->where('idVenda', '=', $venda->idVenda)->delete();
            //salvando produtos da venda
            if (is_array($request->produtos) || is_object($request->produtos)){
                foreach($request->produtos as $produto){
                    // consultando valor do prod
                    $produtoDB = DB::table('produto')
                    ->where([
                        ['produto.deleted_at', '=', null],
                        ['produto.idProduto', '=', $produto]
                    ])
                    ->select('produto.valor')
                    ->first();
                    $itemVenda = new ItemVenda();
                    $itemVenda->idVenda = $venda->idVenda;
                    $itemVenda->idProduto = $produto;
                    $itemVenda->quantidade = 1;
                    $itemVenda->valor = $produtoDB->valor;
                    $itemVenda->save();
                }
            }
            return redirect()->action('VendaController@listar');
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('venda.index')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('venda.index')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }

    function excluir($idVenda = 0) { 
        if ($idVenda != null) {
            $venda = Venda::Where('idVenda', $idVenda)->first();
            $venda->delete();
        }
        return redirect()->action('VendaController@listar');
    }

    /* Usada para consultar o total dos produtos informados na venda */
    function consultaTotalProds(Request $request){
        $produtos = $request->get('produtos');
        $totalProd = 0;
        foreach ($produtos as $prod){
            $produto = DB::table('produto')
            ->where([
                ['produto.deleted_at', '=', null],
                ['produto.idProduto', '=', $prod]
            ])
            ->select('produto.valor')
            ->first();
            $totalProd = $totalProd + $produto->valor;
        }
        return json_encode(number_format($totalProd, 2, ',', ' '));
    }
}
