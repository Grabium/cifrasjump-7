<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TextoController extends Controller
{
  public array $indicados = []; //resreva índices dos caracteres do texto recebido que fazem parte dos naturais 
  public array $array_chor = []; //reserva os chor
  public array $locaisEA = []; //inteiro
  public array $locaisEA_menosDois = []; //string 
  public string $textoMarcado;
  
  public function __construct(string $textoMarcado)
  {
    $this->textoMarcado = $textoMarcado;
  }

 
}
