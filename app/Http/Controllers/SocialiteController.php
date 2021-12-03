<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider(){
        return Socialite::driver('google')->redirect();
    }
    
    public function handleProviderCallback(){
        $user = Socialite::driver('google')->user();

        /* consultando o email do usuario logado, para ver se ja existe em nossa base */
        $userBD = DB::table('usuario')
        ->select('usuario.*')
        ->where('usuario.email', '=', $user->email)
        ->get();

        if (count($userBD) == 1){
            /* apenas atribuimos o user logado e redirect para o index */
            $usuario = Usuario::where(['email' => $user->email])->first();
            Auth::login($usuario);
            return redirect()
                    ->route('home')
                    ->with('message', 'Bem vindo, ' . Auth::user()->nome . '. ' .'Login efetuado com sucesso!')
                    ->withInput();
        }else{
            /* então devemos adicionar o usuário */
            $usuarioSalva = new Usuario();
            $usuarioSalva->nome = $user->name;
            $usuarioSalva->login = $user->email;
            $usuarioSalva->email = $user->email;
            $usuarioSalva->senha = $user->id;
            $usuarioSalva->status = 'a';
            $usuarioSalva->tipo = 'c';
            $usuarioSalva->endereco = 'Cadastro feito através do login via Google.';
            $usuarioSalva->save();

            $usuario = Usuario::where(['email' => $user->email])->first();
            Auth::login($usuario);
            return redirect()
                    ->route('home')
                    ->with('message', 'Bem vindo, ' . Auth::user()->nome . '. ' .'Login efetuado com sucesso!')
                    ->withInput();
        }
    }
}
