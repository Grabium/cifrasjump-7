<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TextoController extends Controller
{
  public string $textoRecebido;

  public function __construct($textoRecebido)
  {
    $this->textoRecebido = $textoRecebido;
  }
}
