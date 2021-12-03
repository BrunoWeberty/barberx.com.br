<?php

namespace App\Providers;

use App\Configuracoes;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
//use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        View::composer(
//            'profile', 'App\Http\ViewComposers\ProfileComposer'
//        );
//
//        // Using Closure based composers...
//        View::composer('dashboard', function ($view) {
//            //
//        }); 
        
        View::composer('*', function($view){
 
            $view 
                //url_host
                ->with('url_host',"https://" . $_SERVER['HTTP_HOST']."/")
                //ações liberadas para o usuário:
                /* ->with('acliente',1) 
                ->with('acombo',1) 
                ->with('adepoimento',1)
                ->with('aespecialista',1)
                ->with('aevento',1) 
                ->with('agaleria',1)
                ->with('anoticia',1)
                ->with('apagina',1) 
                ->with('aparceiro',1)  
                ->with('apergunta',1)  
                ->with('aproduto',1) 
                ->with('aslideshow',1) 
                ->with('avideo',1)  */
                //configurações do sistema
                ->with('configuracoes', Configuracoes::Where('id', 1)->first())
            ;
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
