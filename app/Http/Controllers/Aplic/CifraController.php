<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CifraController extends Controller
{
  //public string $teste;
  public bool $invercao = false;
  public string $acordeConfirmado;
  public int $sizeAcordeConfirmado;

  
  public function __construct()
  {
    //$this->teste = $teste;
  }
}
