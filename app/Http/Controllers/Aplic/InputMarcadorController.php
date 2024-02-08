<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InputMarcadorController extends MarcadorController
{
  protected function setTextoRecebido(string $textoRecebido)
  {
    $caracteres = $this->getLista('caractere');
    $marcadores = $this->getLista('marcador');
    $textoMarcado = str_replace($caracteres, $marcadores, $textoRecebido);
    return $textoMarcado;
  }
}
