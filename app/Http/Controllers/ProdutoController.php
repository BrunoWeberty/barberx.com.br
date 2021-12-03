<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\Categoria;
use App\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    function index($idProduto = 0) {
        if ($idProduto == null) {
            $produto = new Produto();
        } else {
            $produto = Produto::Where('idProduto', $idProduto)->first();
        }
        return view('produto.cadastro', array('produto' => $produto,'marca' => Marca::All()));
    }

    function listar() {
        if (Auth::user()->tipo == 'c'){
            $produto = DB::table('produto')
            ->join('marca','marca.idMarca','=','produto.idMarca')
            ->select('produto.*','marca.descricao as marca')
            ->where([['produto.deleted_at','=',null],['produto.ativo', '=', 'a']])
            ->orderBy('idProduto', 'DESC')
            ->get();
        }else{
            $produto = DB::table('produto')
            ->join('marca','marca.idMarca','=','produto.idMarca')
            ->select('produto.*','marca.descricao as marca')
            ->where('produto.deleted_at','=',null)
            ->orderBy('idProduto', 'DESC')
            ->get();
        }
        return view('produto.lista', array('produto' => $produto));
    }

    function salvar(Request $request) {
        if ($request->get('idProduto') == null) { 
            $produto = new Produto();
        } else {
            $produto = Produto::Where('idProduto', $request->get('idProduto'))->first();
        }

        $produto->idMarca = $request->get('marca');
        $produto->descricao = ($request->get('descricao')  <> '' ? $request->get('descricao') : 'Descrição do produto não preenchida.');
        $produto->ativo = ($request->get('ativo') <> '' ? 'a' : 'i' );
        $produto->valor = $request->get('valor');
        
        //upload da foto da produto
        if ($request->hasFile('img')) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->img->extension();// Recupera a extensão do arquivo
            $nameFile = "{$name}.{$extension}";// Define finalmente o nome
            $upload = $request->img->storeAs('public/produto', $nameFile);// Faz o upload:
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem.')
                    ->withInput();
            $produto->img = 'https://'.$_SERVER['HTTP_HOST'].'/storage/produto/'.$nameFile; 
        }

        try{
            $produto->save();
            return redirect()->action('ProdutoController@listar');
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('produto.index')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('produto.index')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }

    function excluir($idProduto = 0) {
        if ($idProduto != null) {
            $produto = Produto::Where('idProduto', $idProduto)->first();
            if (isset($produto)){
                //Apenas se o registro foi encontrado deverá entrar aqui
                $arquivo = explode('/',$produto->imagem);
                if($produto->imagem <> null || $produto->imagem <> '')
                    // apenas se existe imagem informada no produto que iremos apagar ela
                    Storage::delete('public/produto/'.$arquivo[5]);
                $produto->delete();
            }
            return redirect()->action('ProdutoController@listar');
        }
    }
}
