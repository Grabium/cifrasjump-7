<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TextoController extends Controller
{
  public string $textoMarcado;
  
  public function __construct(string $textoMarcado)
  {
    $this->textoMarcado = $textoMarcado;
  }

 
}
