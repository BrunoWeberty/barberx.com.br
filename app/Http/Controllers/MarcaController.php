<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    function index($idMarca = 0) {
        if ($idMarca == null) {
            $marca = new Marca();
        } else {
            $marca = Marca::Where('idMarca', $idMarca)->first();
        }
        return view('marca.cadastro', array('marca' => $marca));
    }

    function listar() {
        return view('marca.lista', array('marca' => Marca::All()));
    }
    
    function salvar(Request $request) {
        if ($request->get('idMarca') == null) { 
            $marca = new Marca();
        } else {
            $marca = Marca::Where('idMarca', $request->get('idMarca'))->first();
        }
        $marca->descricao = $request->get('descricao');
        //upload da foto da produto
        if ($request->hasFile('img')) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->img->extension();// Recupera a extensão do arquivo
            $nameFile = "{$name}.{$extension}";// Define finalmente o nome
            $upload = $request->img->storeAs('public/marca', $nameFile);// Faz o upload:
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem.')
                    ->withInput();

            $marca->img = 'https://'.$_SERVER['HTTP_HOST'].'/storage/marca/'.$nameFile; 
        } 
        try{
            $marca->save();
            return redirect()->action('MarcaController@listar');
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('marca.index')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('marca.index')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }

    function excluir($idMarca = 0) {
        if ($idMarca != null) {
            if ($idMarca == 1){ 
                // não é permitido excluir o reg 1, afim de evitar erros nas tabelas pai
                return redirect()
                        ->route('marca.lista')
                        ->withErrors('Não é possível excluir este registro, pois é padrão no sistema!');
            }
            $marca = Marca::Where('idMarca', $idMarca)->first();
            $marca->delete();
        }
        return redirect()->action('MarcaController@listar');
    }
}
