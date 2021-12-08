<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function listar()
    {   
        $this->authorize('view', Usuario::class);
        $usuario = DB::table('usuario')
        ->where('usuario.deleted_at', '=', null) 
        ->select('usuario.*')
        ->get();  
        return view('usuarios.listar', array('usuarios' => $usuario));
    }

    public function editar($id = 0)
    {
    //    $this->authorize('update', Usuario::class);
        $usuario = Usuario::find($id);
        return view('usuarios.editar', compact('usuario'));
    }

    public function atualizar(Request $request, $id)
    {
        // $this->authorize('update', Usuario::class);
        $dados = $request->all();
        $usuario = Usuario::find($id);

        //quando manda a senha ele atualiza com senha
        if(!$dados['senha']){
            $senha_antiga = $usuario->senha;
            $dados['senha'] = $senha_antiga;
            $usuario->update($dados);
        }else{
            $senha_nova = Hash::make($dados['senha']);
            $dados['senha'] = $senha_nova;
            $usuario->update($dados);
        }

        return redirect()->route('listar');
    }

    public function registrar()
    {
        //return view('usuarios.registrar');
    }

    public function salvar(Request $request)
    {
        // $this->authorize('create', Usuario::class);
        if ($request->get('id') == null) { 
            $usuario = new Usuario();
        } else {
            $usuario = Usuario::Where('id', $request->get('id'))->first();
        }
        
        //altera senha apenas quando está preenchida
        if (!$request->get('senha') == ''){
            $request['senha'] = bcrypt($request['senha']);
            $usuario->senha = $request->get('senha');
        }
        
        $usuario->nome = $request->get('nome');
        $usuario->login = $request->get('login');
        $usuario->email = $request->get('email');
        $usuario->status = ($request->get('status') <> '' ? 'a' : 'i' );
        $usuario->tipo = $request->get('tipo');
        $usuario->telefone = $request->get('telefone');
        $usuario->endereco = $request->get('endereco');
        $usuario->cpf = $request->get('cpf');
        $usuario->sexo = $request->get('sexo');

        try{
            $usuario->save();
            if (Auth::user()->tipo == 'c'){
                return redirect()
                    ->route('home')
                    ->with('message', 'Informações atualizadas com sucesso!');
            }else{
                return redirect()->action('UsuarioController@listar');
            }
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('usuario')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('usuario')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }

    public function registrarSalvar(Request $request)
    {
        if ($request->get('id') == null) { 
            $usuario = new Usuario();
        } else {
            $usuario = Usuario::Where('id', $request->get('id'))->first();
        }
        
        $usuario->nome = $request->get('nome');
        $usuario->email = $request->get('email');
        $usuario->cpf = $request->get('cpf');
        $usuario->telefone = $request->get('telefone');
        $usuario->sexo = $request->get('sexo');
        $usuario->login = $request->get('login');
        //altera senha apenas quando está preenchida
        if (!$request->get('senha') == ''){
            $request['senha'] = bcrypt($request['senha']);
            $usuario->senha = $request->get('senha');
        }
        $usuario->status = 'a';
        $usuario->tipo = 'c';
        $usuario->endereco = $request->get('endereco');

        try{
            $usuario->save();
            FuncoesController::enviaEmailBemVindo($usuario->email, $usuario->nome);
            return redirect()
                    ->route('login')
                    ->with('message', 'Cadastro realizado com sucesso, realize o login para continuar!');
        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                return redirect()
                    ->route('login')
                    ->withErrors('Existem campos obrigatórios, que não foram preenchidos!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('login')
                    ->withErrors('Ocorreu o seguinte erro ao salvar: ' . $e->getMessage());
            }
        }
    }
    
    function excluir($id = 0) {
        $this->authorize('delete', Usuario::class);
        if ($id != null && $id <> '1') {//validação para não permitir excluir o adm
            $usuario = Usuario::Where('id', $id)->first();
            $usuario->delete();
            return redirect()->action('UsuarioController@listar');
        }else{
            // iremos retornar para a listagem com a mensagem de erro, pois não pode excluir o usuario 1
            $usuario = DB::table('usuario')
            ->where('usuario.deleted_at', '=', null) 
            ->select('usuario.*')
            ->get();  
            return view('usuarios.listar', array('usuarios' => $usuario))
                ->withErrors('Não foi possível excluir o registro pois ele é padrão do sistema.');
        }
    }

    
    function consultaCPF($cpf) {
        $pessoa = DB::table('usuario')
                ->where('usuario.cpf', '=', $cpf) //pegando somente os que ainda nao foram finalizados
                ->select('usuario.*')
                ->first();   
        if (isset($pessoa->nome)) {//existe
            return 1;
        }else{
            return 0;
        }
    } 
    
    function index($id = 0) {
        /* aqui iremos validar se o usuário já está cadastrado */
        /* if (isset(Auth::user()->tipo)){
            dd('EXIISTEEE');
        }else{
            dd('não existe');
        } */
        // $this->authorize('create', Usuario::class);
        if ($id == null) {
            $usuario = new Usuario();
        } else {
            if (Auth::user()->tipo == 'c'){
                $usuario = DB::table('usuario')
                ->where('usuario.id', '=', Auth::user()->id) 
                ->select('usuario.*')
                ->first();  
            }else{
                $usuario = Usuario::Where('id', $id)->first();
            }
        }
        return view('usuarios.registrar', array('usuario' => $usuario));
    }
    
    function alteraMenu() {
        $usuario = Usuario::Where('id', Auth::user()->id)->first();
        if (Auth::user()->menu == 'a' ||Auth::user()->menu == '') {//deve mudar para fechado
            $usuario->menu = 'f';
        } else {//muda para aberto
            $usuario->menu = 'a';
        }
        $usuario->save();
        return 'true';
    }

    static function validaLogin($login){
        $usuario = DB::table('usuario')
                ->where('usuario.login', '=', $login) //pegando somente os que ainda nao foram finalizados
                ->select('usuario.*')
                ->first();   
        if (isset($usuario->nome))//existe
            return true;
        else
            return false;
    }
    
}
