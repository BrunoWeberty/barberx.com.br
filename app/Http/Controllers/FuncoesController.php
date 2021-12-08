<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;
use App\Configuracoes;
use Illuminate\Support\Facades\Auth;

class FuncoesController extends Controller {

    static public function sanitizeString($str) {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
        return $str;
    }

    public static function enviaEmailBemVindo($email, $nome){
        // $emailDestinatario = Auth::user()->email;
        // $nomeDestinatario = Auth::user()->nome;
        $emailDestinatario = $email;
        $nomeDestinatario = $nome;

        $mail = new PHPMailer(); // create 
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP(); // Define que o e-mail será no protocol SMTP
        $mail->Host = 'barberx.com.br'; //endereço do servidor
        
        $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
        $mail->Username = 'barberx@barberx.com.br'; // Usuário do servidor SMTP
        $mail->Password = 'ZLvDG8DSPW!*'; // Senha do servidor SMTP
        
        //  REMETENTE =====
        $mail->From = 'barberx@barberx.com.br'; // Seu e-mail
        $mail->FromName = "Barber X"; // Seu nome       
        $mail->Port = 587; //porta smtp
        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $data = date('d/m/Y'); 
        $hora = date('H:i:s');
        $mail->IsHTML(true);
        $mail->AddAddress($emailDestinatario, $nomeDestinatario);

        $mail->Subject = "- Cadastro BarberX -"; // assunto da mensagem
        $mail->Body = "
                            <!DOCTYPE html>
                                    <html lang='pt-br'>
                                        <head>
                                            <meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
                                            <style>                
                                                table {font-family: arial, sans-serif;border-collapse: collapse}td, th {text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}
                                            </style>
                                        </head>
                                        <body style='margin: 20px 0'>
                                            <table>
                                                <tbody>                 
                                                    <tr>
                                                        <td colspan='2' style='text-align: center' >
                                                            <img alt='' height='100' src='https://barberx.com.br/img/logo.png'>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='border: 1px solid #dddddd;width: 100px;'>Mensagem</td>
                                                        <td style='border: 1px solid #dddddd;width: 200px;'>Seja bem vindo ao sistema, seu cadastro no BarberX foi realizado com sucesso!</td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p style='color: #737478;font-size: 12px'>Enviado às " . $hora . ", " . $data . "</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </body>
                                    </html>";
        
        $enviado = $mail->Send(); 
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
    }

    public static function enviaRecuperacaoSenha($token, $email, $nome){
        // $emailDestinatario = Auth::user()->email;
        // $nomeDestinatario = Auth::user()->nome;
        $emailDestinatario = $email;
        $nomeDestinatario = $nome;

        $mail = new PHPMailer(); // create 
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP(); // Define que o e-mail será no protocol SMTP
        $mail->Host = 'barberx.com.br'; //endereço do servidor
        
        $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
        $mail->Username = 'barberx@barberx.com.br'; // Usuário do servidor SMTP
        $mail->Password = 'ZLvDG8DSPW!*'; // Senha do servidor SMTP
        
        //  REMETENTE =====
        $mail->From = 'barberx@barberx.com.br'; // Seu e-mail
        $mail->FromName = "Barber X"; // Seu nome       
        $mail->Port = 587; //porta smtp
        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $data = date('d/m/Y');
        $hora = date('H:i:s');
        $mail->IsHTML(true);
        $mail->AddAddress($emailDestinatario, $nomeDestinatario);

        $mail->Subject = "- Recuperação de senha BarberX -"; // assunto da mensagem
        $mail->Body = "
                            <!DOCTYPE html>
                                    <html lang='pt-br'>
                                        <head>
                                            <meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
                                            <style>                
                                                table {font-family: arial, sans-serif;border-collapse: collapse}td, th {text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}
                                            </style>
                                        </head> 
                                        <body style='margin: 20px 0'>
                                            <table>
                                                <tbody>                 
                                                    <tr>
                                                        <td colspan='2' style='text-align: center' >
                                                            <img alt='' height='100' src='https://barberx.com.br/img/logo.png'>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='border: 1px solid #dddddd;width: 100px;'>Código</td>
                                                        <td style='border: 1px solid #dddddd;width: 200px;'>" . $token . "</td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p style='color: #737478;font-size: 12px'>Enviado às " . $hora . ", " . $data . "</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </body>
                                    </html>";
        
        $enviado = $mail->Send(); 
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();

        return $enviado;
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