<?php

namespace App\Http\Controllers;

use App\Auditoria;
use Illuminate\Http\Request;
use App\Configuracoes;
use Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //vallido se o usuario for admin então envio as info
        // if (Auth::user()->tipo == 'g'){
            // return view('layouts.master', array('configuracoes' => Configuracoes::Where('id', 1)->first()));
            // return view('layouts.index', array('configuracoes' => Configuracoes::Where('id', 1)->first()));
        // }else{
            return view('layouts.index');
        // }
    }
    
    public function configuracoes(Request $request)
    {// usado para salvar ou atualizar as configurações do sistema
        $validatedData = $request->validate([
            "id" => "required",
        ]);
        $configuracoes = Configuracoes::Where('id', $request->get('id'))->first();
        
        $configuracoes->nomeAplicacao = $request->get('nomeAplicacao');
        $configuracoes->email = $request->get('email');
        $configuracoes->email2 = $request->get('email2');
        $configuracoes->emailSenha = $request->get('emailSenha');
        $configuracoes->emailHost = $request->get('emailHost');
        $configuracoes->nomeAplicacao = $request->get('nomeAplicacao');
        $configuracoes->inicioLicenca = $request->get('inicioLicenca');
        $configuracoes->empresa = $request->get('empresa');
        $configuracoes->titulo = $request->get('titulo');
        $configuracoes->descricao = $request->get('descricao');
        $configuracoes->keywords = $request->get('keywords');
        $configuracoes->url = $request->get('url');
        
        //upload do favicon e logo
        if ($request->hasFile('favicon')) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->favicon->extension();// Recupera a extensão do arquivo
            $nameFile = "{$name}.{$extension}";// Define finalmente o nome
            $upload = $request->favicon->storeAs('public/config', $nameFile);// Faz o upload:
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem.')
                    ->withInput();
            $configuracoes->favicon = 'https://'.$_SERVER['HTTP_HOST'].'/storage/config/'.$nameFile; 
        } 

        if ($request->hasFile('logo')) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->logo->extension();// Recupera a extensão do arquivo
            $nameFile = "{$name}.{$extension}";// Define finalmente o nome
            $upload = $request->logo->storeAs('public/config', $nameFile);// Faz o upload:
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem.')
                    ->withInput();
            $configuracoes->logo = 'https://'.$_SERVER['HTTP_HOST'].'/storage/config/'.$nameFile; 
        } 
        $configuracoes->save();
        return redirect()->action('HomeController@index');
    }
    

    //listagem da auditoria do sistema
    public function auditoria(){
        return view('auditoria.lista', array('auditorias' => Auditoria::All()));
    }
    
    public function relatorioVendas(){
        $funcionarios = DB::table('usuario')
            ->where([['usuario.deleted_at', '=', null],['usuario.tipo', '=', 'f'],['usuario.status', '=', 'a']])
            ->select('usuario.*')
            ->get();  
        $clientes = DB::table('usuario')
            ->where([['usuario.deleted_at', '=', null],['usuario.tipo', '=', 'c'],['usuario.status', '=', 'a']])
            ->select('usuario.*')
            ->get();  
        return view('relatorio.filtra', array('funcionarios' => $funcionarios, 'clientes' => $clientes));
    }

    public function filtraVendas(Request $request){
        $vendasFiltra = DB::table('venda')
        ->where([
            ['venda.deleted_at', '=', null]
        ])
        ->join('usuario','usuario.id','=','venda.idCliente')
        ->select('venda.*','usuario.nome as cliente');

        if ($request['idCliente'] <> ''){
            $vendasFiltra->where('usuario.id', '=', $request['idCliente']);
        }
        if ($request['dtInicial'] <> '' && $request['dtFim'] <> ''){
            $vendasFiltra->where([
                ['venda.created_at', '>', $request['dtInicial'] . ' 00:00:00'],
                ['venda.created_at', '<', $request['dtFim'] . ' 23:59:59']
            ]);
        }

        $vendas = $vendasFiltra->get();
        foreach ($vendas as $vend){
            $itemVenda = DB::table('itemvenda')
            ->where([['itemvenda.deleted_at', '=', null],['itemvenda.idVenda', '=', $vend->idVenda]])
            ->select('itemvenda.*')
            ->get();
            $vend->itemVenda = $itemVenda;

            /* verificando se existe promoção para a venda */
            if ($vend->idPromocao <> ''){
                $promocao = DB::table('promocao')
                ->where([['promocao.deleted_at', '=', null],['promocao.idPromocao', '=', $vend->idPromocao]])
                ->select('promocao.*')
                ->first();
                $vend->promocao = $promocao->descricao;
            }else{
                $vend->promocao = '';
            }
            // dd($vend->obs);
        }
        return view('relatorio.lista', array('vendas' => $vendas));
    }
}
