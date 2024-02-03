<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarcadorController extends Controller
{
  //   < entrada_do_cliente > => < novo_valor >
  //protected $agenteCli = [ "\r\n" => ' % ', "\n"=>' % '];
  protected $naturais = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
  protected $indicados = []; //resreva índices dos caracteres do texto recebido que fazem parte dos naturais 
  protected $array_chor = []; //reserva os chor
  //protected $cifers = []; //reserva os positivos
  //protected $textLines = []; //reserva as linhas de texto
  
}
