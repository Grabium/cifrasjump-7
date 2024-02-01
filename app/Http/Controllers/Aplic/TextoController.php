<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TextoController extends Controller
{
  public string $textoRecebido;
  //   < entrada_do_cliente > => < novo_valor >
  public $agenteCli = [ "\r\n" => ' % ', "\n"=>' % '];

  public function __construct($textoRecebido)
  {
    $this->textoRecebido = $textoRecebido;
  }
}
