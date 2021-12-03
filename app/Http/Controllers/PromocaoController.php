<?php

namespace App\Http\Controllers;

use App\Promocao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromocaoController extends Controller
{
    function index($idPromocao = 0) {
        if ($idPromocao == null) {
            $promocao = new Promocao();
        } else {
            $promocao = Promocao::Where('idPromocao', $idPromocao)->first();
        }
        return view('promocao.cadastro', array('promocao' => $promocao));
    }

    function listar() {
        if (Auth::user()->tipo == 'c'){
            $promocoes = DB::table('promocao')
            ->where([['promocao.deleted_at', '=', null],['promocao.ativo', '=', 'a']])
            ->select('promocao.*')
            ->get();
        }else{
            $promocoes = Promocao::All();
        }
        return view('promocao.lista', array('promocao' => $promocoes));
    }
    
    function salvar(Request $request) {
        if ($request->get('idPromocao') == null) { 
            $promocao = new Promocao($request->all());
        } else {
            $promocao = Promocao::Where('idPromocao', $request->get('idPromocao'))->first();
            $promocao->update($request->all());
        }
        $promocao->ativo = ($request->get('ativo') <> '' ? 'a' : 'i' );
        //upload da img
        if ($request->hasFile('img')) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->img->extension();// Recupera a extensão do arquivo
            $nameFile = "{$name}.{$extension}";// Define finalmente o nome
            $upload = $request->img->storeAs('public/promocao', $nameFile);// Faz o upload:
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem.')
                    ->withInput();
            $promocao->img = 'https://'.$_SERVER['HTTP_HOST'].'/storage/promocao/'.$nameFile; 
        }

        try{
            $promocao->save();
            return redirect()->action('PromocaoController@listar');
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('promocao.index')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('promocao.index')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }

    function excluir($idPromocao = 0) {
        if ($idPromocao != null) {
            $promocao = Promocao::Where('idPromocao', $idPromocao)->first();
            if (isset($promocao)){
                //Apenas se o registro foi encontrado deverá entrar aqui
                $arquivo = explode('/',$promocao->img);
                if($promocao->img <> null || $promocao->img <> '')
                    // apenas se existe imagem informada na promocao que iremos apagar ela
                    Storage::delete('public/promocao/'.$arquivo[5]);
                $promocao->delete();
            }
            return redirect()->action('PromocaoController@listar');
        }
    }
}
