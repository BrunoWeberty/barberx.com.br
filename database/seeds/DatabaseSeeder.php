<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        //configurações do sistema
        DB::table('configuracoes')->insert([
            'id' => 1,
            'email' => 'bruno@gmail.com',
            'email2' => 'bruno@gmail.com',
            'emailSenha' => 'senha',
            'emailHost' => 'gmail.com',
            'nomeAplicacao' => 'MR Barber',
            'inicioLicenca' => '2020-01-01',
            'fimLicenca' => '2023-01-01',
            'empresa' => 'MR Barber',
            'keywords' => 'palavras, chaves, website',
            'titulo' => 'Título do site',
            'descricao' => 'Descreva aqui a descrição do seu site',
            'url' => 'www.seusite.com.br',
            'favicon' => 'http://localhost:8000/storage/config/033510202012245fe40c6e5f02e.png',
            'logo' => 'http://localhost:8000/storage/config/033511202012245fe40c6f88830.png',
            'versao' => '1.0',
        ]);

        //inserindo usuario padrão
        DB::table('usuario')->insert([
            'id' => 1,
            'nome' => 'Administrador Bruno',
            'login' => 'admin',
            'email' => 'bruno@gmail.com',
            'senha' => bcrypt('Çm$4dm!'),
            'status' => 'a',
            'tipo' => 'g',
            'telefone' => '999999999',
            'endereco' => 'Você Sabe!',
            'cpf' => '12002238618',
            'sexo' => 'm',
        ]);

        //inserindo marca geral
        DB::table('marca')->insert([
            'idMarca' => 1,
            'descricao' => 'Geral',
        ]);

    }
}
