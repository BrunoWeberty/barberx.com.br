<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*-----------------------------------*\
    $ROTAS Teste!!!
\*-----------------------------------*/
Route::get('teste/', function(){return view('teste');});
Route::get('testeEmail', 'FuncoesController@testeEmail');


/*-----------------------------------*\
    $ROTAS 
\*-----------------------------------*/
Route::post('/salvar', 'UsuarioController@salvar')->name('salvar');
Route::get('/login', 'AutenticacaoController@login')->name('login');
Route::post('/logar', 'AutenticacaoController@logar')->name('logar');
Route::get('/logout', 'AutenticacaoController@logout')->name('logout');
Route::get('/sair', 'AutenticacaoController@sair')->name('sair');
Route::get('/registrar', 'AutenticacaoController@registrar')->name('registrar');
Route::post('/registrar/salvar', 'UsuarioController@registrarSalvar')->name('registrarSalvar');
Route::get('/esqueceu-senha', 'AutenticacaoController@esqueceuSenha');
Route::post('/enviar-recuperacao', 'AutenticacaoController@enviaEmail');
Route::post('/valida-codigo', 'AutenticacaoController@validaCodigo');

Route::get('login/google', 'SocialiteController@redirectToProvider');
Route::get('login/google/callback', 'SocialiteController@handleProviderCallback');

Route::get('login/facebook', 'SocialiteController@redirectToProvider');
Route::get('login/facebook/callback', 'SocialiteController@handleProviderCallback');

/*-----------------------------------*\
    $ROTAS com middleware
\*-----------------------------------*/

// tudo que esta dentro do middleware se o usuario acessar e NÃO estiver logado ele sera redirecionado
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'AutenticacaoController@privada')->name('dashboard');

    /*-----------------------------------*\
        $ROTAS Usuário
    \*-----------------------------------*/
    Route::get('/usuario/listar', 'UsuarioController@listar')->name('listar');
    Route::get('/usuario/excluir/{id?}', 'UsuarioController@excluir');
    Route::get('/usuario/{id?}', 'UsuarioController@index')->name('usuario');
    Route::post('/usuario/salvar','UsuarioController@salvar');
    Route::get('/alteraMenu','UsuarioController@alteraMenu');
    
    //configurações
    Route::post('/configuracoes','HomeController@configuracoes');
    
    //padrões
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index');
    Route::get('/index', 'HomeController@index');
    Route::get('/auditoria', 'HomeController@auditoria');
    
    /*-----------------------------------*\
    $ROTAS SOL MINAS!
    \*-----------------------------------*/
    Route::get('orcamento','OrcamentoController@index')->name('orcamento');
    Route::get('orcamento/geral','OrcamentoController@listarGeral');
    Route::get('orcamento/listar','OrcamentoController@listarEmAberto');
    Route::post('orcamento/salvar','OrcamentoController@salvar');
    Route::get('orcamento/concluidos','OrcamentoController@listarConcluido');
    Route::get('orcamento/cancelados','OrcamentoController@listarCancelado');
    Route::get('orcamento/reabrir/{idOrcamento}','OrcamentoController@reabrir');
    Route::get('orcamento/cancelar/{idOrcamento}','OrcamentoController@cancelar');
    Route::get('orcamento/concluir/{idOrcamento}','OrcamentoController@concluir');
    Route::get('orcamento/pdf/{idOrcamento}','OrcamentoController@pdf');
    Route::get('orcamento/visualizar/{idOrcamento}','OrcamentoController@pdfView');
    Route::get('orcamento/enviar/{idOrcamento}','OrcamentoController@enviarEmail');
    Route::get('orcamento/v/{lixo1}/{idOrcamento}/{lixo2}','OrcamentoController@pdfV');//vou passar dois parametros lixo o primeiro e o terceiro


    //* ====================================================================================== *\\
    //*                     >>>>>>>>>>>>>ROTAS DA APLICAÇÃO<<<<<<<<<<<<                              *\\
    //* ====================================================================================== *\\

    /*-----------------------------------*\
        $ROTAS Produto
    \*-----------------------------------*/
    Route::get('/produto/listar','ProdutoController@listar');
    Route::post('/produto/salvar','ProdutoController@salvar');
    Route::get('produto/excluir/{idProduto?}','ProdutoController@excluir');
    Route::get('produto/{idProduto?}','ProdutoController@index')->name('produto.index');

    /*-----------------------------------*\
        $ROTAS Marca
    \*-----------------------------------*/
    Route::get('marca/listar','MarcaController@listar')->name('marca.lista');
    Route::post('marca/salvar','MarcaController@salvar');
    Route::get('marca/excluir/{idMarca?}','MarcaController@excluir');
    Route::get('marca/{idMarca?}','MarcaController@index')->name('marca.index');

    /*-----------------------------------*\
        $ROTAS Agendamento
    \*-----------------------------------*/
    Route::get('agendamento/listar','AgendamentoController@listar')->name('agendamento.lista');
    Route::post('agendamento/salvar','AgendamentoController@salvar');
    Route::get('agendamento/excluir/{idAgendamento?}','AgendamentoController@excluir');
    Route::get('agendamento/{idAgendamento?}','AgendamentoController@index')->name('agendamento.index');
    Route::get('agendamento/cancelar/{idAgendamento?}','AgendamentoController@cancelar')->name('agendamento.cancelar');
    Route::get('agendamento/realizar/{idAgendamento?}','AgendamentoController@realizar')->name('agendamento.realizar');
    Route::get('agendamento/agendar/{idAgendamento?}','AgendamentoController@agendar')->name('agendamento.agendar');
    Route::post('filtra-agendamentos','AgendamentoController@filtragem');
    Route::post('consultaHorarios','AgendamentoController@consultaHorarios');
    Route::get('consultaHorarios2','AgendamentoController@consultaHorarios');
    
    Route::post('consultaAgendamento','AgendamentoController@consultaAgendamento');
    Route::post('consultaTotalProds','VendaController@consultaTotalProds');
    
    Route::get('relatorio-vendas','HomeController@relatorioVendas');
    Route::post('filtra-vendas','HomeController@filtraVendas');
    Route::get('grafico','RelatorioController@viewGrafico');
    Route::post('filtra-grafico','RelatorioController@filtraGrafico');

    /*-----------------------------------*\
        $ROTAS Serviço
    \*-----------------------------------*/
    Route::get('servico/listar','ServicoController@listar')->name('servico.lista');
    Route::post('servico/salvar','ServicoController@salvar');
    Route::get('servico/excluir/{idServico?}','ServicoController@excluir');
    Route::get('servico/{idServico?}','ServicoController@index')->name('servico.index');
     
    /*-----------------------------------*\
        $ROTAS Venda
    \*-----------------------------------*/
    Route::get('venda/listar','VendaController@listar')->name('venda.lista');
    Route::post('venda/salvar','VendaController@salvar');
    Route::get('venda/excluir/{idVenda?}','VendaController@excluir');
    Route::get('venda/{idVenda?}','VendaController@index')->name('venda.index');

    /*-----------------------------------*\
        $ROTAS Promoção
    \*-----------------------------------*/
    Route::get('promocao/listar','PromocaoController@listar')->name('promocao.lista');
    Route::post('promocao/salvar','PromocaoController@salvar');
    Route::get('promocao/excluir/{idPromocao?}','PromocaoController@excluir');
    Route::get('promocao/{idPromocao?}','PromocaoController@index')->name('promocao.index');

    
    /*-----------------------------------*\
        $ROTAS aaaaaaaaaaaaa
    \*-----------------------------------*/
    Route::get('aaaaaaaaaaaaaaaaaaa/listar','aaaaaaaffssffssssssssssssssss@listar')->name('afffffffffff.lista');
    Route::post('aaaaaaaaaaaaaaaaaaa/salvar','aaaaaaaffssffssssssssssssssss@salvar');
    Route::get('aaaaaaaaaaaaaaaaaaa/excluir/{idAaaaaaaaaaaaaaaa?}','aaaaaaaffssffssssssssssssssss@excluir');
    Route::get('aaaaaaaaaaaaaaaaaaa/{idAaaaaaaaaaaaaaaa?}','aaaaaaaffssffssssssssssssssss@index')->name('afffffffffff.index');
});