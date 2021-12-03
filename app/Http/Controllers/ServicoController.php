<?php

namespace App\Http\Controllers;

use App\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    function index($idServico = 0) {
        if ($idServico == null) {
            $servico = new Servico();
        } else {
            $servico = Servico::Where('idServico', $idServico)->first();
        }
        return view('servico.cadastro', array('servico' => $servico));
    }

    function listar() {
        return view('servico.lista', array('servico' => Servico::All()));
    }
    
    function salvar(Request $request) {
        if ($request->get('idServico') == null) { 
            $servico = new Servico($request->all());
        } else {
            $servico = Servico::Where('idServico', $request->get('idServico'))->first();
            $servico->update($request->all());
        }
        $servico->ativo = ($request->get('ativo') <> '' ? 'a' : 'i' );

        //upload da img
        if ($request->hasFile('img')) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->img->extension();// Recupera a extensão do arquivo
            $nameFile = "{$name}.{$extension}";// Define finalmente o nome
            $upload = $request->img->storeAs('public/servico', $nameFile);// Faz o upload:
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem.')
                    ->withInput();
            $servico->img = 'https://'.$_SERVER['HTTP_HOST'].'/storage/servico/'.$nameFile; 
        }

        try{
            $servico->save();
            return redirect()->action('ServicoController@listar');
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('servico.index')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('servico.index')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }

    function excluir($idServico = 0) { 
        if ($idServico != null) {
            $servico = Servico::Where('idServico', $idServico)->first();
            $servico->delete();
        }
        return redirect()->action('ServicoController@listar');
    }
}
