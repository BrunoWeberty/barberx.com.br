<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Usuario;
use Illuminate\Support\Facades\DB;

class AutenticacaoController extends Controller
{
    public function home()
    {
        return view('publica');
    }

    public function privada()
    {
        return view('privada');
    }

    public function login()
    {
        return view('autenticacao.login');
    }

    public function registrar()
    {
        if (isset(Auth::user()->tipo)){
            /* tratando o acesso para usuarios que ja estejam logados */
            return redirect()
                    ->route('home')
                    ->with('message', 'Atenção usuário você já está cadastrado no sistema!');
        }else{
            $usuario = new Usuario();
            return view('autenticacao.registrar', array('usuario' => $usuario))->with('message', 'Realize seu cadastro para acessar o sistema.');
        }
    }
    
    public function loginInvalido()
    {
        $mensagemRet = true;
        return view('autenticacao.login', array('mensagemRet' => $mensagemRet));
    }

    public function logar(Request $request)
    {
        
        $dados = $request->all();
        $login = $dados['login'];
        $senha = $dados['senha'];
        
       $wheres = ['login' => $login, 'status' => 'a'];
        // $wheres = ['login' => $login];
        //$usuario = Usuario::where('login', $login)->first();
        $usuario = Usuario::where($wheres)->first();

        if(Auth::check() || ($usuario && Hash::check($senha, $usuario->senha))){
            Auth::login($usuario);
            //validando a data de vencimento da licença
            $configuracoes = DB::table('configuracoes')
                ->select('configuracoes.*')
                ->where('fimLicenca', '>=', now())
                ->get(); 

            if (count($configuracoes)){//LICENCA VALIDA
                return redirect()
                    ->route('home')
                    // ->with('message', 'Bem vindo, ' . Auth::user()->nome . '. ' .'Login efetuado com sucesso! Licença válida até: ' . date('d/m/Y', strtotime($configuracoes[0]->fimLicenca)) . '.')
                    ->with('message', 'Bem vindo, ' . Auth::user()->nome . '. ' .'Login efetuado com sucesso!')
                    ->withInput();
            }else{
                return redirect()
                    ->route('login')
                    ->withErrors('Sua Licença de uso do sistema Expirou! Procure o administrador.')
                    ->withInput();
            }

        } else {   
            return redirect()
                    ->route('login')
//                    ->withErrors(['mensagem' => 'Senha ou login inválidos!',])
                    ->withErrors('Login ou Senha inválidos!')
                    ->withInput();//isso salva os dados que o usuario digitou para nao digitar de novo
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function sair()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function esqueceuSenha(){
        return view('autenticacao.esqueceu-senha')->with('message', 'Informe seu e-mail de cadastro para prosseguir.');
    }

    public function enviaEmail(Request $request){
        // vamos verificar se o email do usuario existe
        $usuario = DB::table('usuario')
                ->select('usuario.*')
                ->where('email', '=', $request->get('email'))
                ->first();
        if (isset($usuario->email)){
            /* devemos enviar o email */
            $token = rand(100000, 999999);
            DB::table('usuario')->where('id', '=', $usuario->id)->update(['remember_token' => $token]);
            $ret = FuncoesController::enviaRecuperacaoSenha($token, $usuario->email, $usuario->nome);
            return view('autenticacao.valida-codigo')->with('message', 'Confira seu e-mail e informe o código recebido, para recuperar sua senha.');
        }else{
            return view('autenticacao.esqueceu-senha')->with('message', 'O e-mail informado não existe em nossa base de dados.');
        }
    }

    public function validaCodigo(Request $request){
        // vamos verificar se o codigo do usuario existe
        $usuario = DB::table('usuario')
                ->select('usuario.*')
                ->where('remember_token', '=', $request->get('cod'))
                ->first();
        if (isset($usuario->email)){
            /* limpando o token */
            DB::table('usuario')->where('id', '=', $usuario->id)->update(['remember_token' => '']);
            /* redirecionando para a edição do usuario */
            $usuarioLogado = Usuario::where(['id' => $usuario->id])->first();
            Auth::login($usuarioLogado);
            return redirect(route('usuario',[$usuario->id]));
            // return \Redirect::route('usuario', [$usuario->id]);
        }else{
            return view('autenticacao.valida-codigo')->withErrors('O código informado não é válido! Favor verificar e tentar novamente.');
        }
    }
    
}
