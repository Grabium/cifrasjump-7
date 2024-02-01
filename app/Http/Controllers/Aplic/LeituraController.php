<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


//grava os índices que possuem naturais

class LeituraController extends Controller
{

  private TextoController $texto;
  
  public function __construct($textoRecebido)
  {
    $this->texto = new TextoController($textoRecebido);
  }

  public function getTextoRecebido()
  {
    return $this->texto->textoRecebido;
  }
}
