<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /* 
        a consulta do relatorio de vendas foi feita no HomeController
        aqui temos apenas a do grafico
    */
    public function viewGrafico(){
        return view('relatorio.filtra-grafico');
    }

    public function filtraGrafico(Request $request){
        $jan = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-01-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-01-31 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $fev = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-02-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-02-28 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $mar = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-03-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-03-31 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $abr = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-04-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-04-30 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $mai = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-05-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-05-31 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $jun = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-06-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-06-30 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $jul = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-07-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-07-31 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $ago = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-08-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-08-31 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $set = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-09-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-09-30 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $out = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-10-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-10-31 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $nov = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-11-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-11-30 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $dez = DB::table('venda')
        ->where([['venda.deleted_at', '=', null]])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->where([
            ['venda.created_at', '>', $request->get('ano') . '-12-01 00:00:00'],
            ['venda.created_at', '<', $request->get('ano') . '-12-31 23:59:59']
        ])
        ->select('venda.*','usuario.nome as cliente')->get();
 
        $grafico = [
            count($jan),
            count($fev),
            count($mar),
            count($abr),
            count($mai),
            count($jun),
            count($jul),
            count($ago),
            count($set),
            count($out),
            count($nov),
            count($dez),
        ];

        return view('relatorio.lista-grafico', array('ano' => $request->get('ano'), 'grafico' => $grafico));
    }

}
