<?php

namespace App\Http\Controllers\Aplic\Conversao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConversorController extends Controller
{
  protected int $fator;
  
  public function __construct(int $fator)
  {
    $this->fator = $fator;
  }
  public function faseConversao($analisado)
  {
    //dd($analisado);
    
    return $analisado;
  }
}
