<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;
use App\Configuracoes;

class FuncoesController extends Controller {

    function testeEmail(){
    }

    static function enviarEmail() { 
                
    }
    
    function soNumeros($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
    
    function consultaCPFCNPJ() {

    }
    
    function consultarCPFCNPJ(Request $request) {

    } 

}