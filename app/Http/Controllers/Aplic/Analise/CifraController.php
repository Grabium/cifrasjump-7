<?php

namespace App\Http\Controllers\Aplic\Analise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CifraController extends Controller
{
  //public string $teste;
  
  public string $acordeConfirmado;
  public int    $sizeAcordeConfirmado;
  public bool   $enarmonia             = false;
  public bool   $tercaMenor            = false;
  public bool   $composto              = false;
  public bool   $invercao              = false;
  
  
  
  
  
  
  public function __construct()
  {
    //$this->teste = $teste;
  }
}
